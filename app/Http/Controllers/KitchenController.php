<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderedItem;
use App\Enums\ItemStatus;

class KitchenController extends Controller
{
    public function show()
    {
        $orders = Order::getAllOrders();
        return view("kitchen", compact(["orders"]));
    }

    public function progressItemStatus(string $itemId)
    {
        $orderedItem = OrderedItem::find($itemId);

        switch ($orderedItem->status) {
            case "to do":
                $orderedItem->status = "in progress";
                $orderedItem->save();

                $order = $orderedItem->order;
                if ($order->status == "to do") {
                    $this->setOrderStatus($order, "in progress");
                }

                break;

            case "in progress":
                $orderedItem->status = "done";
                $orderedItem->save();

                $order = $orderedItem->order;
                if ($this->isOrderDone($order)) {
                    $this->setOrderStatus($order, "ready");
                }
                break;

            case "done":
                $orderedItem->status = "to do";
                $orderedItem->save();
                $order = $orderedItem->order;
                if ($order->status == "ready") {
                    $this->setOrderStatus($order, "in progress");
                }
                break;

            default:
                $msg = "I Am Error";
                break;
        }
        return back();
    }

    public function setOrderStatus(Order $order, string $status)
    {
        $order->status = $status;
        $order->save();
    }

    public function isOrderDone(Order $order): bool
    {
        $orderedItems = $order->orderedItems;

        $orderID = $order->id;
        foreach ($orderedItems as $item) {
            if ($item->status != ItemStatus::DONE->value) {
                return false;
            }
        }
        return true;
    }

    public function closeOrder(string $id)
    {
        $order = Order::find($id);
        $order->status = "done";
        $order->save();

        return back();
    }
}
