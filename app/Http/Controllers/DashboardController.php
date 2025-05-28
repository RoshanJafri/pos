<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $orders = Order::orderBy('updated_at', 'desc')->where('status',0)->paginate(20);
        return view('dashboard',['orders' => $orders]);
    }
}
