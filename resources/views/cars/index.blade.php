@extends('layouts.app')

@section('content')
    <header>
        <h1>Car Listings</h1>
    </header>

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-3">
                <select id="filterMakes" class="form-control select2">
                    <option value="">All Makes</option>
                    @foreach ($makes as $make)
                        <option value="{{ $make }}">{{ $make }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <select id="filterModels" class="form-control select2">
                    <option value="">All Models</option>
                    @foreach ($models as $model)
                        <option value="{{ $model }}">{{ $model }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <select id="filterYear" class="form-control select2">
                    <option value="">All Years</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <select id="filterFuel" class="form-control select2">
                    <option value="">All Fuel Types</option>
                    @foreach ($fuel_types as $fuel)
                        <option value="{{ $fuel }}">{{ $fuel }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <input type="number" id="filterMinPrice" class="form-control" placeholder="Min Price"
                    min={{ $min_price }} max={{ $max_price - 1 }} step="1" value={{ $min_price }}>
            </div>

            <div class="col-md-3">
                <input type="number" id="filterMaxPrice" class="form-control" placeholder="Max Price"
                    min={{ $min_price + 1 }} max={{ $max_price }} step="1" value={{ $max_price }}>
            </div>
        </div>

        <div id="carList" class="row">
            @foreach ($cars as $car)
                <div class="col-md-4 mb-3 car-card" data-make="{{ $car->make }}" data-model="{{ $car->model }}"
                    data-year="{{ $car->year }}" data-fuel="{{ $car->fuel_type }}">
                    <div class="card">
                        @if ($car->images->isNotEmpty())
                            <div id="carousel{{ $car->id }}" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($car->images as $key => $image)
                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                            <img src="{{ $image->url }}" class="d-block w-100"
                                                alt="{{ $car->name }}">
                                        </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carousel{{ $car->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carousel{{ $car->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        @else
                            <img src="{{ asset('images/default-car.jpg') }}" class="card-img-top" alt="Default Image">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $car->name }}</h5>
                            <p class="card-text">
                                <strong>Price:</strong> {{ $car->price }}<br>
                                <strong>Year:</strong> {{ $car->year }}<br>
                                <strong>Fuel:</strong> {{ $car->fuel }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cars.css') }}">
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            function filterCars() {
                const make = $('#filterMakes').val();
                const model = $('#filterModels').val();
                const year = $('#filterYear').val();
                const fuel = $('#filterFuel').val();
                const minPrice = parseInt($('#filterMinPrice').val());
                const maxPrice = parseInt($('#filterMaxPrice').val());

                $('.car-card').each(function() {
                    const card = $(this);
                    const matchMake = !make || card.data('make') == make;
                    const matchModel = !model || card.data('model') == model;
                    const matchYear = !year || card.data('year') == year;
                    const matchFuel = !fuel || card.data('fuel') == fuel;
                    const matchPrice = !(minPrice && maxPrice) || card.data('price') >= minPrice && card
                        .data('price') <= maxPrice;

                    if (matchMake && matchModel && matchYear && matchFuel && matchPrice) {
                        card.show();
                    } else {
                        card.hide();
                    }
                });
            }

            $('#filterMakes, #filterModels, #filterYear, #filterFuel, #filterMinPrice, #filterMaxPrice').on(
                'change', filterCars);
        });
    </script>
@endpush
