<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

    public function addToOrder(Request $request)
    {
        $validated = $request->validate([
            "notes" => "string|nullable|max:255",
        ]);
        return back()->with("message", "$request->item_name added to order");
    }

    public function showOrder(string $tableNumber)
    {
        return view("orders.showOrder", compact("tableNumber"));
    }
}
