<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderedItem;

class KitchenController extends Controller
{
    public function show()
    {
        $orders = Order::getAllOrders();
        // dd($o rders);
        return view("kitchen", compact(["orders"]));
    }

    public function showKitchenOrders(Request $request)
    {
        // TODO validation
        return $this->showOrders();
    }
}
