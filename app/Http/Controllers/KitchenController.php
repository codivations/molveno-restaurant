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
        $ordered_items = OrderedItem::getAllOrderedItems();
        return view("kitchen", compact(["orders", "ordered_items"]));
    }

    public function showKitchenOrders(Request $request)
    {
        // TODO validation
        return $this->showOrders();
        return $this->showOrderedItems();
    }
}
