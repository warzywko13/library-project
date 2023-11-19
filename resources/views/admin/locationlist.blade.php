@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex flex-row flex-row-reverse mb-3">
            <a href="/admin/location/addedit/" class="btn btn-outline-primary">{{ __('Dodaj Nowy') }}</a>
        </div>

        @if($locations)
            <table class="table table-striped border">
                <thead>
                <tr>
                    <th scope="col" class="col-1">{{__('Id')}}</th>
                    <th scope="col" class="col-1">{{__('Nazwa')}}</th>
                    <th scope="col" class="col-7">{{__('X')}}</th>
                    <th scope="col" class="col-2">{{__('Y')}}</th>
                    <th scope="col" class="col-1">{{__('Edytuj')}}</th>
                    <th scope="col" class="col-1">{{__('Usuń')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($locations as $location)
                    <tr>
                        <th scope="row">{{ $location->id }}</th>
                        <td>{{ $location->name }}</td>
                        <td>{{ $location->X }}</td>
                        <td>{{ $location->Y }}</td>
                        <td>
                            <a href="/admin/location/addedit/{{ $location->id }}" class="btn btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </td>
                        <td>
                            <form method="POST" action="/admin/location/delete" onsubmit="return confirm('{{ __('Czy na pewno chcesz usunąć?') }}')">
                                @csrf
                                <input type="hidden" name="id" value="{{ $location->id }}" />
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div>{{__('Brak danych')}}</div>
        @endif
    </div>
@endsection
