<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TablesController extends Controller
{
    public function show(): View
    {
        $tables = Table::orderBy("id")->get();
        return view("tables.index", compact(["tables"]));
    }
}
