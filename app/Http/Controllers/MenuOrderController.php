<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuOrderController extends Controller
{
    public function index(): View
    {
        return view("orders.index");
    }
}
