@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex flex-row-reverse gap-2 mb-3">
            <form method="POST" action="/admin/addedit">
                @csrf
                <button type="submit" class="btn btn-outline-primary">{{ __('Dodaj Nowy') }}</button>
            </form>
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
                        <th scope="row">{{ $book->id }}</th>
                        <td>{{ $book->name }}</td>
                        <td>{{ $book->count }}</td>
                        <td>
                            <a href="/admin/addedit/{{ $book->id }}" class="btn btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </td>
                        <td>
                            <form method="POST" action="/admin/delete" onsubmit="return confirm('{{ __('Czy na pewno chcesz usunąć?') }}')">
                                @csrf
                                <input type="hidden" name="id" value="{{ $book->id }}" />
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
