<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $cars = Car::when($request->filled('make'), function ($query) use ($request) {
            $query->where('make', $request->make);
        })->when($request->filled('fuel_type'), function ($query) use ($request) {
            $query->where('fuel_type', $request->fuel_type);
        })->when($request->filled('year'), function ($query) use ($request) {
            $query->where('year', $request->year);
        })->when($request->filled('price_min'), function ($query) use ($request) {
            $query->where('price', '>=', $request->price_min);
        })->when($request->filled('price_max'), function ($query) use ($request) {
            $query->where('price', '<=', $request->price_max);
        });

        $makes = Car::distinct('make')->pluck('make');
        $models = Car::distinct('model')->pluck('model');
        $years = Car::distinct('year')->pluck('year');
        $fuel_types = Car::distinct('fuel_type')->pluck('fuel_type');
        [$min_price, $max_price] = Car::query()->selectRaw('MIN(price) as min_price, MAX(price) as max_price')->first(['min_price', 'max_price'])->toArray();

        return view('cars.index', [
            'cars' => $cars->latest()->paginate($request->per_page ?? 10),
            'makes' => $makes,
            'models' => $models,
            'years' => $years,
            'fuel_types' => $fuel_types,
            'min_price' => $min_price,
            'max_price' => $max_price,
        ]);
    }

    public function show(Car $car)
    {
        $car->load('features:id,name', 'images:id,image_path');

        return view('cars.show', compact('car'));
    }
}
