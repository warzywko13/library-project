@extends('layouts.app')

@section('content')
    <div class="container">

        @if($reservations)
            <table class="table table-striped border">
                <thead>
                <tr>
                    <th scope="col" class="col-1">{{__('Id')}}</th>
                    <th scope="col" class="col-1">{{__('Nazwa')}}</th>
                    <th scope="col" class="col-7">{{__('Lokalizacja')}}</th>
                    <th scope="col" class="col-2">{{__('Od')}}</th>
                    <th scope="col" class="col-1">{{__('Do')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reservations as $reservation)
                    <tr>
                        <th scope="row">{{ $reservation->id }}</th>
                        <td>{{ $reservation->book }}</td>
                        <td>{{ $reservation->location }}</td>
                        <td>{{ substr($reservation->from, 0, 10) }}</td>
                        <td>{{ substr($reservation->to, 0, 10) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div>{{__('Brak danych')}}</div>
        @endif
    </div>
@endsection
