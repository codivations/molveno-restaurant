<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TablesController extends Controller
{
    public function show(string $area = "all", string $seated = "all"): View
    {
        $areaSelected = $area;
        $seatedSelected = $seated;

        $query = Table::orderBy("id");
        if ($areaSelected != "all") {
            //dd($areaSelected);
            $query = $query->where("seating_area", $areaSelected);
        }

        $collection = $query->get();

        if ($seatedSelected == "available") {
            $collection = $collection->filter(function ($value, $key) {
                if (!$value["seated_reservation"]) {
                    return $value;
                }
            });
        } elseif ($seatedSelected == "occupied") {
            $collection = $collection->filter(function ($value, $key) {
                if ($value["seated_reservation"]) {
                    return $value;
                }
            });
        }

        $tables = $collection;

        return view(
            "tables.index",
            compact(["tables", "areaSelected", "seatedSelected"])
        );
    }
}
