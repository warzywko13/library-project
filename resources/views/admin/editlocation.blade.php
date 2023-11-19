@extends('layouts.app')

@section('content')
    <div class="container" >
        <h1 class="text-center fw-bold py-2">@isset($location['id']) {{ __('Edytuj lokalizację') }} @else {{ __('Dodaj lokalizację') }} @endisset</h1>

        <form method="POST" action="/admin/location/addedit" enctype="multipart/form-data" novalidate>
            @csrf
            <input name="id" type="hidden" value="@isset($location['id']){{$location['id']}}@endisset" />

            <div class="form-group">
                <label for="name">{{__('Nazwa')}}</label>
                <input required type="string" class="form-control" name="name" id="name" value="@isset($location['name']){{$location['name']}}@endisset" />
                @isset($error['name'])
                    <p class="text-danger fw-bold">{{ $error['name'] }}</p>
                @endisset
            </div>

            <div class="mb-3">
                <label for="x" class="form-label"> {{ __('X') }}:</label>
                <input required type="number" class="form-control" id="x" name="x" value="{{ isset($location['X']) ? $location['X'] : '' }}">
            </div>
            
            <div class="mb-3">
                <label for="y" class="form-label"> {{ __('Y') }}:</label>
                <input required type="number" class="form-control" id="y" name="y" value="{{ isset($location['Y']) ? $location['Y'] : '' }}">
            </div>

            <button type="submit" name="submit" value="1" class="btn btn-outline-primary">{{ __('Zapisz') }}</button>
            <button type="button" class="btn btn-outline-secondary" id="getLocation">{{ __('Pobierz lokalizację') }}</button>
        </form>
    </div>

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
