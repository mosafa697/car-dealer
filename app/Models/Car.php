<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $guarded = [];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function images()
    {
        return $this->hasMany(CarImage::class);
    }

    public function features()
    {
        return $this->hasMany(CarFeature::class);
    }

    public function getNameAttribute()
    {
        return "$this->make - $this->model ($this->year)";
    }
}
