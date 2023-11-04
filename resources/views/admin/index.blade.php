@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="float-end mb-3">
            <a href="/admin/addedit">
                <button type="button" class="btn btn-outline-primary">{{__('Dodaj Nowy')}}</button>
            </a>
        </div>

        @if($books)
            <table class="table table-striped border">
                <thead>
                <tr>
                    <th scope="col" class="col-1">{{__('Id')}}</th>
                    <th scope="col" class="col-7">{{__('Nazwa')}}</th>
                    <th scope="col" class="col-2">{{__('Ilość')}}</th>
                    <th scope="col" class="col-1">{{__('Edytuj')}}</th>
                    <th scope="col" class="col-1">{{__('Usuń')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($books as $book)
                    <tr>
                        <th scope="row">{{$book->id}}</th>
                        <td>{{$book->name}}</td>
                        <td>{{$book->count}}</td>
                        <td>
                            <a href="/admin/addedit/{{$book->id}}" class="text-decoration-none">{{__('Edytuj')}}</a>
                        </td>
                        <td>
                            <a href="#" class="text-decoration-none">{{__('Usuń')}}</a>
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
