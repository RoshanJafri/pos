<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\Order;
use App\Models\Category;
use App\Models\Employee;
use Mike42\Escpos\Printer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Mike42\Escpos\EscposImage;
use Illuminate\Support\Facades\DB;
use Mike42\Escpos\CapabilityProfile;
use Illuminate\Support\Facades\Storage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $orders = Order::with(['details.item', 'employee'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('id', $request->search);
            })
            ->orderByDesc('created_at')
            ->paginate(5)
            ->withQueryString(); // keeps search param during pagination

        return view('orders.index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with(['subCategories.items'])->get();
        $employees = Employee::select('id', 'name')
            ->orderByDesc('name')
            ->get();

        $open_orders = Order::where('status', 1)->get();

        return view('orders.create', [
            'categories' => $categories,
            'employees' => $employees,
            'open_orders' => $open_orders,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'receipt_count' => 'required|integer|min:0|max:3',
            'employee_id' => 'required|numeric',
            'table_no' => 'nullable',
            'subtotal' => 'required|numeric|min:0',
            'discountPercentage' => 'nullable|numeric|min:0|max:100',
            'payable' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:500',
            'order_type' => 'required|string|in:dine_in,takeaway,delivery',
        ], [
            'employee_id.required' => 'Please select a server/employee for this order.',
            'employee_id.numeric' => 'The server/employee must be selected.',
        ]);

        // Save main order
        $order = new Order();
        $order->employee_id = $request->employee_id;
        $order->table_no = $request->table_no;
        $order->subtotal = $request->subtotal;
        $order->tax = $request->tax;
        $order->discountPercentage = $request->discountPercentage;
        $order->payable = $request->payable;
        $order->note = $request->note;
        $order->order_type = $request->order_type;
        $order->app = $request->delivery_app;
        $order->status = 0;
        $order->save();

        // Save order details
        foreach ($request->items as $item) {
            $order->details()->create([
                'item_id' => $item['id'],
                'name' => $item['name'],
                'quantity' => $item['qty'],
                'finalCost' => $item['cost'],
                'originalCost' => $item['originalCost'],
            ]);
        }
        for ($i = 0; $i < $request->receipt_count; $i++) {
            $this->printKOT($order->id, $order->created_at, $order->employee->name, $request->items, [], $order->table_no);
        }
        return redirect()->route('dashboard')->with('success', 'Order updated successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::with(['subCategories.items'])->get();

        $employees = cache()->remember('employees', 3600, function () {
            return Employee::select('id', 'name')->orderByDesc('name')->get();
        });
        $order = Order::with(['details.item'])->findOrFail($id);
        return view('orders.edit', [
            'order' => $order,
            'employees' => $employees,
            'categories' => $categories
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'employee_id' => 'required',
            'table_no' => 'nullable',
            'subtotal' => 'required|numeric|min:0',
            'discountPercentage' => 'nullable|numeric|min:0|max:100',
            'payable' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:500',
            'order_type' => 'required|string|in:dine_in,takeaway,delivery',
        ]);

        // Save main order
        $order = Order::findOrFail($id);

        $oldItems = $order->details()->get();

        $incomingIds = collect($request->items)->pluck('id')->toArray();

        // Delete removed items
        $order->details()->whereNotIn('item_id', $incomingIds)->delete();

        // Add or update items
        foreach ($request->items as $item) {
            $orderDetail = $order->details()->where('item_id', $item['id'])->first();

            if ($orderDetail) {
                // Update existing
                $orderDetail->update([
                    'name' => $item['name'],
                    'quantity' => $item['qty'],
                    'finalCost' => $item['cost'],
                    'originalCost' => $item['originalCost'],
                ]);
            } else {
                // Add new
                $order->details()->create([
                    'item_id' => $item['id'],
                    'name' => $item['name'],
                    'quantity' => $item['qty'],
                    'finalCost' => $item['cost'],
                    'originalCost' => $item['originalCost'],
                ]);
            }
        }


        $order->employee_id = $request->employee_id;
        $order->table_no = $request->table_no;
        $order->subtotal = $request->subtotal;
        $order->tax = $request->tax;
        $order->discountPercentage = $request->discountPercentage;
        $order->payable = $request->payable;
        $order->note = $request->note;
        $order->order_type = $request->order_type;
        $order->app = $request->delivery_app;
        $order->status = 0;
        $order->save();

        foreach ($request->items as $item) {
            $orderDetail = $order->details()->where('item_id', $item['id'])->first();

            if ($orderDetail) {

                // Update existing order detail
                $orderDetail->update([
                    'name' => $item['name'],
                    'quantity' => $item['qty'],
                    'finalCost' => $item['cost'],
                    'originalCost' => $item['originalCost'],
                ]);
            } else {
                // Create new order detail if it doesn't exist
                $order->details()->create([
                    'item_id' => $item['id'],
                    'name' => $item['name'],
                    'quantity' => $item['qty'],
                    'finalCost' => $item['cost'],
                    'originalCost' => $item['originalCost'],
                ]);
            }
        }
        if ($request->input('print_receipt')) {
            $this->printKOT($order->id, $order->updated_at, $order->employee->name, $request->items, $oldItems, $order->table_no, $update = TRUE);
        }
        return redirect()->route('dashboard')->with('success', 'Order updated successfully!');
    }

    private function printKOT($order_id, $order_time, $handler, $items, $oldItems, $table_no, $update = FALSE)
    {


        $connector = new WindowsPrintConnector('XP-80C-1');
        $printer = new Printer($connector);
        $order = Order::findOrFail($order_id);
        $printer->setTextSize(2, 2); // Max text size
        $printer->setEmphasis(true); // Bold

        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("KITCHEN ORDER\n\n");

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("KOT Printed #: " . date('H:i A, d-M-Y', strtotime($order_time)) . "\n");
        $printer->text("Order #: " . $order_id . "\n");
        $printer->text("Table #: " . $table_no . "\n\n");

        $printer->text("Note: " . $order->note . "\n\n");

        $printer->text("Server: " . ($handler ?? 'N/A') . "\n");

        $printer->text(str_repeat("-", 23) . "\n");

        $printer->setJustification(Printer::JUSTIFY_CENTER);

        if ($update) {
            $printer->text("UPDATED ORDER DETAILS\n");
        }

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        foreach ($items as $item) {
            $itemName = ucfirst($item['name']);

            $line = str_pad($item['qty'] . "x", 4) . $itemName;

            $printer->feed(); // Feeds one line (empty)
            $printer->text($line . "\n");
        }

        $printer->feed(2); // feed 3 lines
        $printer->cut(); // cut the paper
        $printer->close();
    }

    public function officeReceipt(Request $request, $order)
    {

        $paymentMethod = $request->input('payment_method');
        $order = Order::with('employee', 'details.item')->findOrFail($order);
        $order->status = 1;
        $order->payment_method = $paymentMethod;
        $order->save();


        // ✅ SUBTRACT PORTIONS STOCK
        foreach ($order->details as $detail) {

            $portionId = $detail->item->portion_id;
            $qtyUsed = $detail->quantity;

            if ($portionId) {
                DB::table('portions')
                    ->where('id', $portionId)
                    ->decrement('quantity', $qtyUsed);
            }
        }

        if ($request->input('print_receipt')) {
            $connector = new WindowsPrintConnector('XP-80C-1');
            $printer = new Printer($connector);

            $printer->text("Print Date and time: " . date('Y-m-d h:i A') . "\n");
            $printer->text("Order Date and time: " . date('Y-m-d h:i A', strtotime($order->created_at)) . "\n\n");

            // Restaurant copy header
            $printer->setEmphasis(true);
            $printer->text("***RESTAURANT COPY***\n");
            $printer->setEmphasis(false);

            $printer->text("Server/Handler: " . $order->employee->name . "\n");
            $printer->text("Table No: " . $order->table_no . "\n\n");

            // 🏢 Address block
            $printer->text("========== KAFE KARACHI ==========\n");
            $printer->text("4 Inner Vanderwert Pl, Dehiwala\n");
            $printer->text("074-2833278\n\n");

            // 📄 Order info
            $printer->text("Order # " . $order->id . "\n");
            $printer->text("Payment: " . $paymentMethod . "\n");
            $printer->text("Note: " . $order->note . "\n\n");

            // Separator line
            $printer->text(str_repeat("-", 42) . "\n");

            // Header columns
            $printer->text(
                str_pad("Qty", 5) .
                str_pad("Item", 17) .
                str_pad("Rate", 10, ' ', STR_PAD_LEFT) .
                str_pad("Price", 10, ' ', STR_PAD_LEFT) . "\n"
            );
            $printer->text(str_repeat("-", 42) . "\n");

            // Items
            foreach ($order->details as $item) {
                $name = strlen($item->item->name) > 15
                    ? substr($item->item->name, 0, 12) . '...'
                    : $item->item->name;

                $line = str_pad($item->quantity, 5) .
                    str_pad($name, 17) .
                    str_pad(number_format($item->originalCost, 2), 10, ' ', STR_PAD_LEFT) .
                    str_pad(number_format($item->finalCost * $item->quantity, 2), 10, ' ', STR_PAD_LEFT);

                $printer->text($line . "\n");
            }

            // 💵 Totals
            $printer->text(str_repeat("-", 42) . "\n");
            $printer->text(str_pad("Subtotal: ", 30, ' ', STR_PAD_LEFT) . "Rs. " . number_format($order->subtotal, 2) . "\n");
            $printer->text(str_pad("Tax: ", 30, ' ', STR_PAD_LEFT) . "Rs. " . number_format($order->tax, 2) . "\n");

            if ($order->discountPercentage > 0) {
                $printer->text(str_pad("Discount: ", 30, ' ', STR_PAD_LEFT) . number_format($order->discountPercentage, 2) . "%\n");
            }

            $printer->text(str_repeat("=", 42) . "\n");
            $printer->setEmphasis(true);
            $printer->text(str_pad("TOTAL: ", 30, ' ', STR_PAD_LEFT) . "Rs. " . number_format($order->payable, 2) . "\n");
            $printer->setEmphasis(false);
            $printer->text(str_repeat("=", 42) . "\n\n");

            $printer->feed(3);
            $printer->cut();
            $printer->close();
        }
    }

    public function clientReceipt($order, $printerName = 'XP-80C-1')
    {

        $order = Order::findOrFail($order);

        try {
            $connector = new WindowsPrintConnector('XP-80C-1');
            $printer = new Printer($connector);

            $printer->setTextSize(1, 1);
            $printer->text("Date: " . date('Y-m-d h:i A') . "\n\n");

            // Restaurant name big, bold, centered
            $printer->setTextSize(2, 2);
            $printer->setEmphasis(true);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("KAFE KARACHI\n");
            $printer->setEmphasis(false);
            $printer->setTextSize(1, 1);

            // Address & phone centered, normal text
            $printer->text("4 Inner Vanderwert Pl, Dehiwala\n");
            $printer->text("074-2833278\n\n");

            // Order info, left aligned
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Order #" . $order->id . "\n");
            $printer->text("Note: " . $order->note . "\n\n");
            $printer->text(str_repeat("-", 42) . "\n");

            // Header columns
            // Header columns
            $printer->text(
                str_pad("Qty", 5) .
                str_pad("Item", 17) .
                str_pad("Rate", 10, ' ', STR_PAD_LEFT) .
                str_pad("Price", 10, ' ', STR_PAD_LEFT) . "\n"
            );
            $printer->text(str_repeat("-", 42) . "\n");

            // Items
            foreach ($order->details as $item) {
                $name = strlen($item->item->name) > 15
                    ? substr($item->item->name, 0, 12) . '...'
                    : $item->item->name;

                // Complementary item
                if ((float) $item->finalCost == 0) {

                    $line =
                        str_pad($item->quantity, 5) .
                        str_pad($name, 17) .
                        str_pad('', 10) .
                        str_pad('', 10);

                    $printer->text($line . "\n");

                    // Print "complementary" in tiny text
                    $printer->setTextSize(1, 1);
                    $printer->text(
                        str_pad('', 5) .
                        str_pad('complementary', 37) . "\n"
                    );

                } else {

                    // Normal priced item
                    $line =
                        str_pad($item->quantity, 5) .
                        str_pad($name, 17) .
                        str_pad(number_format($item->originalCost, 2), 10, ' ', STR_PAD_LEFT) .
                        str_pad(number_format($item->finalCost * $item->quantity, 2), 10, ' ', STR_PAD_LEFT);

                    $printer->text($line . "\n");
                }
            }

            // Totals with padding
            $printer->text(str_repeat("-", 42) . "\n");
            $printer->text(str_pad("Subtotal: Rs. " . number_format($order->subtotal, 2), 42, ' ', STR_PAD_LEFT) . "\n");
            $printer->text(str_pad("Tax: Rs. " . number_format($order->tax, 2), 42, ' ', STR_PAD_LEFT) . "\n");
            if ($order->discountPercentage > 0) {
                $printer->text(str_pad("Discount: " . number_format($order->discountPercentage, 2) . "%", 42, ' ', STR_PAD_LEFT) . "\n");
            }
            $printer->text(str_repeat("=", 42) . "\n");

            // Total bolded
            $printer->setEmphasis(true);
            $printer->text(str_pad("Total: Rs. " . number_format($order->payable, 2), 42, ' ', STR_PAD_LEFT) . "\n");
            $printer->setEmphasis(false);
            $printer->text(str_repeat("=", 42) . "\n\n");

            // Footer centered, with padding
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Thank you for dining with us!\n");
            $printer->text("Visit again!\n");

            // Add empty lines for readability / paper feed
            $printer->feed(4);

            // Cut the paper
            $printer->cut();

            // Close printer connection
            $printer->close();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Printing failed: ' . $e->getMessage()
            ], 500);
        }
        return response('', 200);
    }

    public function destroy(Request $request, string $id)
    {

        if ($request->admin_code !== env('DELETE_PASSWORD', '8014')) {
            return back()->withErrors([
                'admin_code' => 'Invalid password'
            ]);
        }

        $order = Order::findOrFail($id);
        $order->delete();

        return back()->with('success', 'Order deleted successfully');
    }
}
