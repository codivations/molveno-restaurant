<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TablesController extends Controller
{
    public function show(): View
    {
        $areaSelected = "all";
        $seatedSelected = "all";
        $tables = Table::orderBy("id")->get();
        return view(
            "tables.index",
            compact(["tables", "areaSelected", "seatedSelected"])
        );
    }

    public function showFiltered(string $area, string $seated): View
    {
        $areaSelected = $area;
        $seatedSelected = $seated;
        $tables = Table::orderBy("id")->get();
        return view(
            "tables.index",
            compact(["tables", "areaSelected", "seatedSelected"])
        );
    }
}
