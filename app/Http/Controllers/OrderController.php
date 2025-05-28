<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Category;
use App\Models\Employee;
use Mike42\Escpos\Printer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\CapabilityProfile;
use Illuminate\Support\Facades\Storage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $orders = Order::with(['details.item', 'employee'])
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        return view('orders.index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $categories = cache()->remember('categories', 3600, function () {
        //     return Category::with(['subcategories.items'])->get();
        // });
        $categories = Category::with(['subCategories.items'])->get();

        $employees = cache()->remember('employees', 3600, function () {
            return Employee::select('id', 'name')->orderByDesc('name')->get();
        });

        $open_orders = Order::where('status', 1)->get();

        return view('orders.create', [
            'categories'   => $categories,
            'employees'    => $employees,
            'open_orders'  => $open_orders,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
        $order = new Order();
        $order->employee_id = $request->employee_id;
        $order->table_no = $request->table_no;
        $order->subtotal = $request->subtotal;
        $order->tax = $request->tax;
        $order->discountPercentage = $request->discountPercentage;
        $order->payable = $request->payable;
        $order->note = $request->note;
        $order->order_type = $request->order_type;
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
        // $this->printKOT($order->id, $order->employee->name, $request->items, $order->table_no);
        // return redirect()->route('dashboard')->with('success', 'Order updated successfully!');

        return $this->printKOT($order->id, $order->employee->name, $request->items, [], $order->table_no);
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
     */ public function edit(string $id)
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


        $order->employee_id = $request->employee_id;
        $order->table_no = $request->table_no;
        $order->subtotal = $request->subtotal;
        $order->tax = $request->tax;
        $order->discountPercentage = $request->discountPercentage;
        $order->payable = $request->payable;
        $order->note = $request->note;
        $order->order_type = $request->order_type;
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
        return $this->printKOT($order->id, $order->employee->name, $request->items, $oldItems, $order->table_no);

        // $this->printKOT($order->id, $order->employee->name, $request->items, $order->table_no);
        // return redirect()->route('dashboard')->with('success', 'Order updated successfully!');
    }

    private function printKOT($order_id, $handler, $items, $oldItems, $table_no)
    {
        $order = Order::findOrFail($order_id);
        $content = '';
        $content .= "KITCHEN ORDER\n";
        $content .= "Order #: " . $order_id . "\n";
        $content .= "Table #: " . $table_no . "\n\n";
        $content .= "Note: " . $order->note . "\n\n";
        $content .= "Server: " . ($handler ?? 'N/A') . "\n";
        $content .= str_repeat("-", 32) . "\n";

        $content .= "========UPDATED ORDER DETAILS=======\n";

        foreach ($items as $item) {
            $content .= str_pad($item['qty'] . "x", 4) . $item['name'] . "\n";
        }

        if (count($oldItems) > 0) {
            $content .= "=========OLD ORDER DETAILS=========\n";
            $content .= "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx\n";

            foreach ($oldItems as $item) {
                $content .= str_pad($item['quantity'] . "x", 4) . $item['name'] . "\n";
            }
        }

        $content .= "\n\n\n";

        // Return as text file download
        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="kitchen_order.txt"');
    }
    public function officeReceipt(Request $request, $order)
    {
        $paymentMethod = $request->input('payment_method');
        $order = Order::with('employee', 'details.item')->findOrFail($order);
        $order->status = 1;
        $order->payment_method = $paymentMethod;
        $order->save();

        $printerOutput = '';

        // 🗓️ Header Info
        $printerOutput .= "Print Date and time: " . date('Y-m-d h:i A') . "\n\n";
        $printerOutput .= "Order Date and time: " . date('Y-m-d h:i A', strtotime($order->created_at)) . "\n\n";

        $printerOutput .= "***RESTAURANT COPY***\n";
        $printerOutput .= "Server/Handler: " . $order->employee->name . "\n";
        $printerOutput .= "Table No: " . $order->table_no . "\n\n";

        // 🏢 Header
        $printerOutput .= "========== KAFE KARACHI ==========\n";
        $printerOutput .= "4 Inner Vanderwert Pl, Dehiwala\n";
        $printerOutput .= "074-2833278\n\n";

        // 📄 Order Info
        $printerOutput .= "Order # " . $order->id . "\n";
        $printerOutput .= "Payment: " . $paymentMethod . "\n";
        $printerOutput .= "------------------------------------------\n";

        // 🛒 Items Header
        $printerOutput .= str_pad("Qty", 5) . str_pad("Item", 22) . str_pad("Price", 10, ' ', STR_PAD_LEFT) . "\n";
        $printerOutput .= "------------------------------------------\n";

        // 🛍️ Items
        $total = 0;
        foreach ($order->details as $item) {
            $name = mb_strimwidth($item->item->name, 0, 20, "...");
            $line = str_pad($item->quantity, 5) .
                str_pad($name, 22) .
                str_pad("Rs. " . number_format($item->finalCost * $item->quantity, 2), 10, ' ', STR_PAD_LEFT);
            $printerOutput .= $line . "\n";
            $total += $item->finalCost;
        }

        // 💵 Totals
        $printerOutput .= "------------------------------------------\n";
        $printerOutput .= str_pad("Subtotal: ", 30, ' ', STR_PAD_LEFT) . "Rs. " . number_format($order->subtotal, 2) . "\n";
        $printerOutput .= str_pad("Tax: ", 30, ' ', STR_PAD_LEFT) . "Rs. " . number_format($order->tax, 2) . "\n";
        if ($order->discountPercentage > 0) {
            $printerOutput .= str_pad("Discount: ", 30, ' ', STR_PAD_LEFT) . number_format($order->discountPercentage, 2) . "%\n";
        }

        $printerOutput .= str_repeat("=", 42) . "\n";
        $printerOutput .= str_pad("TOTAL: ", 30, ' ', STR_PAD_LEFT) . "Rs. " . number_format($order->payable, 2) . "\n";
        $printerOutput .= str_repeat("=", 42) . "\n\n";

        $printerOutput = str_replace("\n", "\r\n", $printerOutput);
        return response()->streamDownload(function () use ($printerOutput) {
            echo $printerOutput;
        }, 'office-receipt.txt', [
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Cache-Control' => 'no-store, no-cache',
        ]);
    }

    public function clientReceipt($order, $printerName = 'XP-80C')
    {

        $order = Order::findOrFail($order);

        $lines = [];

        // 🗓️ Header Info
        $lines[] = "Date: " . date('Y-m-d h:i A') . "\n";

        // 🏢 Restaurant Info
        $lines[] = str_pad("KAFE KARACHI", 42, ' ', STR_PAD_BOTH);
        $lines[] = str_pad("4 Inner Vanderwert Pl, Dehiwala", 42, ' ', STR_PAD_BOTH);
        $lines[] = str_pad("074-2833278", 42, ' ', STR_PAD_BOTH);
        $lines[] = "\n";

        // 📄 Order Info
        $lines[] = "Order #" . $order->id;
        $lines[] = str_repeat("-", 42);
        $lines[] = str_pad("Qty", 5) . str_pad("Item", 22) . str_pad("Price", 10, ' ', STR_PAD_LEFT);
        $lines[] = str_repeat("-", 42);

        $total = 0;
        foreach ($order->details as $item) {
            $name = mb_strimwidth($item->item->name, 0, 20, "...");
            $line = str_pad($item->quantity, 5) .
                str_pad($name, 22) .
                str_pad("Rs. " . number_format($item->finalCost * $item->quantity, 2), 10, ' ', STR_PAD_LEFT);
            $lines[] = $line;
            $total += $item->finalCost;
        }

        // 💵 Totals
        $lines[] = str_repeat("-", 42);
        $lines[] = str_pad("Subtotal: Rs. " . number_format($order->subtotal, 2), 42, ' ', STR_PAD_LEFT);
        $lines[] = str_pad("Tax: Rs. " . number_format($order->tax, 2), 42, ' ', STR_PAD_LEFT);

        if ($order->discountPercentage > 0) {
            $lines[] = str_pad("Discount: " . number_format($order->discountPercentage, 2) . "%", 42, ' ', STR_PAD_LEFT);
        }

        $lines[] = str_repeat("=", 42);
        $lines[] = str_pad("Total: Rs. " . number_format($order->payable, 2), 42, ' ', STR_PAD_LEFT);
        $lines[] = str_repeat("=", 42);
        $lines[] = "";

        // 🙏 Footer
        $lines[] = str_pad("Thank you for dining with us!", 42, ' ', STR_PAD_BOTH);
        $lines[] = str_pad("Visit again!", 42, ' ', STR_PAD_BOTH);

        // Generate and return the file
        $fileContent = implode("\n", $lines);
        $filename = 'receipt_' . $order->id . '_' . Str::random(5) . '.txt';
        return response($fileContent)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="receipt.txt"');
    }
    public function accounts(Request $request)
    {
        $total = 0;
        if ($request->start_date) {
            $total = Order::whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ])->sum('payable');
        } else {

            if ($request->period == 'week') {
                $total = Order::whereDate('created_at', '>=', now()->subDays(6)->startOfDay())->sum('payable');
            } else if ($request->period == 'all_time') {
                $total = Order::sum('payable');
            } else {
                $total = Order::whereDate('created_at', today())->sum('payable');
            }
        }
        return view(
            'orders.accounts',
            [
                'total' => $total,
                'period' => $request->period,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]
        );
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
