<?php

namespace App\Livewire\Forms;

use App\Models\Car;
use Livewire\Component;
use Livewire\WithFileUploads;

class CarForm extends Component
{
    use WithFileUploads;

    public $make, $model, $year, $price, $fuel_type;
    public $features = [];
    public $images = [];

    public $editing = false;
    public $carId;

    public function openAddModal()
    {
        $this->resetFields();
        $this->dispatch('show-modal', 'carModal');
        $this->dispatch('car-modal-shown');
    }

    public function edit($id)
    {
        $car = Car::with(['features', 'images'])->findOrFail($id);

        $this->carId = $car->id;
        $this->make = $car->make;
        $this->model = $car->model;
        $this->year = $car->year;
        $this->price = $car->price;
        $this->fuel_type = $car->fuel_type;
        $this->features = $car->features->map(fn($f) => [
            'name' => $f->name,
            'description' => $f->description
        ])->toArray();
        $this->editing = true;

        $this->dispatch('show-modal', 'carModal');
        $this->dispatch('car-modal-shown');
    }

    public function addFeature()
    {
        $this->features[] = ['name' => '', 'description' => ''];
    }

    public function removeFeature($index)
    {
        unset($this->features[$index]);
        $this->features = array_values($this->features);
    }

    public function saveCar()
    {
        $car = Car::create([
            'make' => $this->make,
            'model' => $this->model,
            'year' => $this->year,
            'price' => $this->price,
            'fuel_type' => $this->fuel_type,
        ]);

        foreach ($this->features as $feature) {
            $car->features()->create([
                'name' => $feature['name'],
                'description' => $feature['description'],
            ]);
        }

        if ($this->images) {
            foreach ($this->images as $image) {
                $path = $image->store('cars', 'public');
                $car->images()->create(['image_path' => $path]);
            }
        }

        $this->dispatch('hide-modal', 'carModal');
        $this->resetFields();
    }

    public function updateCar()
    {
        $car = Car::findOrFail($this->carId);
        $car->update([
            'make' => $this->make,
            'model' => $this->model,
            'year' => $this->year,
            'price' => $this->price,
            'fuel_type' => $this->fuel_type,
        ]);

        $car->features()->delete();
        foreach ($this->features as $feature) {
            $car->features()->create([
                'name' => $feature['name'],
                'description' => $feature['description'],
            ]);
        }

        if ($this->images) {
            foreach ($this->images as $image) {
                $path = $image->store('cars', 'public');
                $car->images()->create(['image_path' => $path]);
            }
        }

        $this->dispatch('hide-modal', 'carModal');
        $this->resetFields();
    }

    public function resetFields()
    {
        $this->reset(['make', 'model', 'year', 'price', 'fuel_type', 'features', 'images', 'editing', 'carId']);
        $this->features = [['name' => '', 'description' => '']];
    }

    public function render()
    {
        return view('livewire.car-form');
    }
}
