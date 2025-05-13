<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CarController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Car::qurey()
                ->with('features:id,name')
                ->with('images:id,image_path')
                ->select(['id', 'make', 'model', 'year', 'price', 'fuel_type']))
                ->make(true);
        }
    }
}
