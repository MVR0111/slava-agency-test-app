<?php

namespace App\Http\Controllers;

use App\Models\Row;
use Illuminate\Http\Request;

class RowsController extends Controller
{
    public function index()
    {
        $rows = Row::all()->groupBy(function ($item) {
            return $item->date->format('d.m.Y');
        });
        return view('rows', ['rows' => $rows]);
    }
}
