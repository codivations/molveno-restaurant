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
}
