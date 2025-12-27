<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function index()
    {

        $baseQuery = Order::where('status', 1);


        // PickMe
        $pickmeOrdersCount = (clone $baseQuery)
            ->where('app', 'pick_me')
            ->count();

        $pickmeSales = (clone $baseQuery)
            ->where('app', 'pick_me')
            ->sum('payable');

        // Uber Eats
        $uberOrdersCount = (clone $baseQuery)
            ->where('app', 'uber_eats')
            ->count();

        $uberSales = (clone $baseQuery)
            ->where('app', 'uber_eats')
            ->sum('payable');


        $todaySale = (clone $baseQuery)
            ->whereDate('created_at', today())
            ->sum('payable');

        $yesterdaySale = (clone $baseQuery)
            ->whereDate('created_at', Carbon::yesterday())
            ->sum('payable');

        $last7DaysSale = (clone $baseQuery)
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->sum('payable');

        $allTimeSale = (clone $baseQuery)
            ->sum('payable');

        $items = Item::orderBy('name', 'ASC')->get();

        return view('accounts.index', compact(
            'todaySale',
            'yesterdaySale',
            'last7DaysSale',
            'allTimeSale',
            'items',
            'pickmeOrdersCount',
            'pickmeSales',
            'uberOrdersCount',
            'uberSales'
        ));
    }

    public function salesShow(Request $request)
    {
        // Items always needed for filter dropdown
        $items = Item::select('id', 'name')->orderBy('name')->get();

        // Default empty state
        $orders = collect();
        $totalSale = null;

        // Only validate & query IF user tries to filter
        if ($request->filled('start_date') || $request->filled('end_date')) {

            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ], [
                'start_date.required' => 'Please select a start date.',
                'end_date.required' => 'Please select an end date.',
            ]);

            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();

            $query = Order::with(['employee', 'details'])
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 1);

            /* ======================
                App Filter
            ====================== */
            $app = $request->app ?? 'all_sales';

            if ($app === 'all') {
                $query->whereIn('app', ['uber_eats', 'pick_me']);
            } elseif ($app !== 'all_sales') {
                $query->where('app', $app);
            }

            /* ======================
                Order Type Filter
            ====================== */
            if ($request->filled('order_type') && $request->order_type !== 'all') {
                $query->where('order_type', $request->order_type);
            }

            /* ======================
                Item Filter
            ====================== */
            if ($request->filled('item_id')) {
                $query->whereHas('details', function ($q) use ($request) {
                    $q->where('item_id', $request->item_id);
                });
            }

            /* ======================
                Fetch Orders
            ====================== */
            $orders = $query->latest()->get();

            /* ======================
                Total Sale
            ====================== */
            if ($request->filled('item_id')) {
                // Total of selected item only
                $totalSale = $orders
                    ->flatMap->details
                    ->where('item_id', $request->item_id)
                    ->sum('finalCost');
            } else {
                // Total payable of orders
                $totalSale = $orders->sum('payable');
            }
        }

        return view('accounts.sales_show', compact(
            'orders',
            'items',
            'totalSale'
        ));
    }

    public function showDay($date)
    {
        // detailed breakdown per day
    }
    public function itemsSold(Request $request)
    {
        $from = $request->input('from_date');
        $to = $request->input('to_date');

        $items = collect();

        if ($from && $to) {
            $items = DB::table('order_details')
                ->join('orders', 'orders.id', '=', 'order_details.order_id')
                ->whereBetween('orders.created_at', [
                    $from . ' 00:00:00',
                    $to . ' 23:59:59'
                ])
                ->where('orders.status', 1) // only completed orders
                ->select(
                    'order_details.name',
                    DB::raw('SUM(order_details.quantity) as total_sold')
                )
                ->groupBy('order_details.name')
                ->orderByDesc('total_sold')
                ->get();
        }

        return view('accounts.items_sold', compact(
            'items',
            'from',
            'to'
        ));
    }

    public function filter(Request $request)
    {
        // Validate inputs with custom messages
        $request->validate([
            'start_date' => 'required_with:end_date|date',
            'end_date' => 'required_with:start_date|date',
        ], [
            'start_date.required_with' => 'Please select a start date to filter sales.',
            'end_date.required_with' => 'Please select an end date to filter sales.',
            'start_date.date' => 'Start date is not a valid date.',
            'end_date.date' => 'End date is not a valid date.',
        ]);

        $query = Order::query();

        // Inclusive Date Range Filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = $request->start_date . ' 00:00:00';
            $end = $request->end_date . ' 23:59:59';
            $query->whereBetween('created_at', [$start, $end]);
        }

        // App Filter
        $app = $request->app ?? 'all_sales';
        if ($app === 'all') {
            $query->whereIn('app', ['uber_eats', 'pick_me']);
        } elseif ($app !== 'all_sales') {
            $query->where('app', $app);
        }

        // Order Type Filter
        if ($request->filled('order_type') && $request->order_type !== 'all') {
            $query->where('order_type', $request->order_type);
        }

        // Item Filter
        $itemId = $request->item_id ?? null;
        if ($itemId) {
            // Join with order_details to sum money spent on this item
            $query->whereHas('details', function ($q) use ($itemId) {
                $q->where('item_id', $itemId);
            });

            $total = DB::table('order_details')
                ->join('orders', 'orders.id', '=', 'order_details.order_id')
                ->where('order_details.item_id', $itemId)
                ->when($request->filled('start_date') && $request->filled('end_date'), function ($q) use ($start, $end) {
                    $q->whereBetween('orders.created_at', [$start, $end]);
                })
                ->when($app === 'all', fn($q) => $q->whereIn('orders.app', ['uber_eats', 'pick_me']))
                ->when($app !== 'all_sales' && $app !== 'all', fn($q) => $q->where('orders.app', $app))
                ->when($request->filled('order_type') && $request->order_type !== 'all', fn($q) => $q->where('orders.order_type', $request->order_type))
                ->sum('order_details.finalCost');
        } else {
            // Total payable for all orders in the query
            $total = $query->sum('payable');
        }

        $orders = $query->get();
        $items = Item::all();


        $baseQuery = Order::where('status', 1);

        $todaySale = (clone $baseQuery)
            ->whereDate('created_at', today())
            ->sum('payable');

        $yesterdaySale = (clone $baseQuery)
            ->whereDate('created_at', Carbon::yesterday())
            ->sum('payable');

        $last7DaysSale = (clone $baseQuery)
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->sum('payable');

        $allTimeSale = (clone $baseQuery)
            ->sum('payable');


        // PickMe
        $pickmeOrdersCount = (clone $baseQuery)
            ->where('app', 'pick_me')
            ->count();

        $pickmeSales = (clone $baseQuery)
            ->where('app', 'pick_me')
            ->sum('payable');

        // Uber Eats
        $uberOrdersCount = (clone $baseQuery)
            ->where('app', 'uber_eats')
            ->count();

        $uberSales = (clone $baseQuery)
            ->where('app', 'uber_eats')
            ->sum('payable');

        return view('accounts.index', [
            'orders' => $orders,
            'items' => $items,
            'total' => $total,
            'start_date' => $request->start_date ?? '',
            'end_date' => $request->end_date ?? '',
            'period' => null,
            'app_selected' => $app,
            'order_type_selected' => $request->order_type ?? 'all',
            'item_selected' => $itemId,
            'todaySale' => $todaySale,
            'yesterdaySale' => $yesterdaySale,
            'last7DaysSale' => $last7DaysSale,
            'allTimeSale' => $allTimeSale,
            'pickmeOrdersCount' => $pickmeOrdersCount,
            'pickmeSales' => $pickmeSales,
            'uberOrdersCount' => $uberOrdersCount,
            'uberSales' => $uberSales,
        ]);
    }

    /**
     * 
     * Remove the specified resource from storage.
     */


}
