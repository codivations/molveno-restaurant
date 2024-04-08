<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Table;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use stdClass;

class MenuOrderController extends Controller
{
    public function index(): View
    {
        $menu = Menu::with("items")->get();

        return view("orders.index", compact("menu"));
    }

    public function showMenu(string $tableNumber)
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
        $validated = $request->validate([
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
            session(["order" => $this->createOrderObject($request)]);
        }

        array_push(session("order")->items, [
            "menu_item_id" => $request->menu_item_id,
            "notes" => $request->notes ?? "",
            "dietary_restrictions" => $request->has("dietary_restrictions"),
        ]);

        return back()->with("message", "$request->item_name added to order");
    }

    public function showOrder(string $tableNumber): View
    {
        return view("orders.showOrder", compact("tableNumber"));
    }

    private function createOrderObject(Request $request): object
    {
        $order = new stdClass();
        $order->items = [];
        $order->staff_id = $request->user()->id;

        return $order;
    }
}
