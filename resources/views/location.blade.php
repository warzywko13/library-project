@extends('layouts.app')

@section('content')
    <form class="container" action="/settings" method="POST" novalidate>
        <h1 class="text-center fw-bold py-2">{{ __('Pobierz lokalizację') }}</h1>

        @csrf    

        <div class="mb-3">
            <label for="x" class="form-label">{{ __('X') }}:</label>
            <input required type="number" class="form-control" id="x" name="x" aria-describedby="x" value="{{ $p['x'] }}">
        </div>
        
        <div class="mb-3">
            <label for="y" class="form-label"> {{ __('Y') }}:</label>
            <input required type="number" class="form-control" id="y" name="y" value="{{ $p['y'] }}">
        </div>

        <button type="submit" name="save" value="1" class="btn btn-outline-primary">{{ __('Zapisz') }}</button>
        <button type="button" class="btn btn-outline-secondary" id="getLocation">{{ __('Pobierz lokalizację') }}</button>
    </form>

    <script type="text/javascript">
        const getLocation = document.getElementById('getLocation');
        const x = document.getElementById('x');
        const y = document.getElementById('y');

        getLocation.addEventListener('click', function() {
            navigator.geolocation.getCurrentPosition(function(position) {
                const latitude = parseFloat(position.coords.latitude);
                const longitude = parseFloat(position.coords.longitude);

                x.value = latitude;
                y.value = longitude;
            });
        });
    </script>
@endsection
