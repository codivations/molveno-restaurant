<?php

namespace App\Http\Controllers;

use App\Enums\ItemStatus;
use App\Enums\OrderStatus;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderedItem;
use App\Models\Table;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use stdClass;

class MenuOrderController extends Controller
{
    public function showMenu(string $tableNumber): View
    {
        return $this->showService($tableNumber, "lunch");
    }

    public function showService(
        string $tableNumber,
        string $currentService
    ): View {
        $menuNames = Menu::all("service");
        $menu = Menu::where("service", $currentService)
            ->with("items")
            ->first();

        return view(
            "orders.service",
            compact("menu", "menuNames", "tableNumber", "currentService")
        );
    }

    public function addToOrder(
        Request $request,
        string $tableNumber
    ): RedirectResponse {
        $request->validate([
            "notes" => "string|nullable|max:255",
        ]);

        $table = Table::where("table_number", $tableNumber)->first();

        if (empty($table)) {
            return redirect("/tables")->with(
                "warning",
                "Table does not exist."
            );
        }

        if (empty($table->seated)) {
            return back()->with(
                "warning",
                "There is no reservation at this table"
            );
        }

        if (empty(session("order"))) {
            session([
                "order" => $this->createOrderObject($tableNumber),
            ]);
        }

        array_push(session("order")->items, [
            "menu_item_id" => $request->menu_item_id,
            "item_name" => $request->item_name,
            "notes" => $request->notes ?? "",
            "dietary_restrictions" => $request->has("dietary_restrictions"),
            "price" => $request->price,
        ]);

        return back()->with("message", "$request->item_name added to order");
    }

    public function showOrder(string $tableNumber): View|RedirectResponse
    {
        $table = Table::where("table_number", $tableNumber)->first();

        if (empty($table)) {
            return redirect("/tables")->with(
                "warning",
                "Table does not exist."
            );
        }

        $previousOrders = Order::where(
            "reservation_id",
            $table->seated_reservation
        )->get();

        $totalPrice = $this->makePriceSum($table);

        return view(
            "orders.showOrder",
            compact("tableNumber", "previousOrders", "totalPrice")
        );
    }

    public function sendOrder(string $tableNumber): RedirectResponse
    {
        if (empty(session("order"))) {
            return back()->with("error", "Cannot send empty order");
        }

        $table = Table::where("table_number", $tableNumber)->first();
        $reservation_id = $table->seated_reservation;

        $order = new Order();
        $order->staff_id = auth()->user()->id;
        $order->reservation_id = $reservation_id;
        $order->status = OrderStatus::TO_DO;
        $order->save();

        foreach (session("order")->items as $item) {
            $orderedItem = new OrderedItem();

            $orderedItem->order()->associate($order);
            $orderedItem->order_id = $order->id;
            $orderedItem->menu_item_id = $item["menu_item_id"];
            $orderedItem->status = ItemStatus::TO_DO;
            $orderedItem->dietary_restrictions = $item["dietary_restrictions"];
            $orderedItem->notes = $item["notes"];

            $orderedItem->save();
        }

        session()->forget("order");

        return back()->with("success", "Order sent");
    }

    public function updateOrder(Request $request): RedirectResponse
    {
        $request->validate([
            "notes" => "string|nullable|max:255",
        ]);

        session("order")->items[$request->index]["notes"] =
            $request->notes ?? "";

        session("order")->items[$request->index][
            "dietary_restrictions"
        ] = $request->has("dietary_restrictions");

        return back()->with("success", "item updated");
    }

    public function removeFromOrder(Request $request): RedirectResponse
    {
        $order = session()->pull("order");
        array_splice($order->items, $request->index, 1);
        session(["order" => $order]);

        return back()->with("success", "item removed");
    }

    private function createOrderObject(string $tableNumber): object
    {
        $order = new stdClass();
        $order->items = [];
        $order->tableNumber = $tableNumber;

        return $order;
    }

    private function makePriceSum($table): string
    {
        $totalPrice = 0;
        $prices = [];
        $previousOrders = Order::where(
            "reservation_id",
            $table->seated_reservation
        )->get();
        foreach ($previousOrders as $order) {
            foreach ($order->orderedItems as $orderItem) {
                $itemPrice = $orderItem->item->price;
                array_push($prices, $itemPrice);
            }
        }
        $totalPrice = array_sum($prices) / 100;

        return "€ " . number_format($totalPrice, 2);
    }
}
