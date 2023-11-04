@extends('layouts.app')

@section('content')
    <div class="container">

        <h1 class="text-center fw-bold py-2">{{isset($book->id) ? __('Edytuj książkę') : __('Dodaj książkę')}}</h1>

        <form method="POST" action="/admin/addedit" >
            @csrf
            <input name="id" type="hidden" value="{{isset($book->id) ? $book->id : ''}}" />

            <div class="form-group">
                <label for="name">{{__('Nazwa')}}</label>
                <input type="string" class="form-control" name="name" id="name" value="{{isset($book->name) ? $book->name : ''}}" />
            </div>

            <div class="form-group mt-2">
                <label for="description">{{__('Ilość')}}</label>
                <input type="number" class="form-control" id="count" name="count" value="{{isset($book->count) ? $book->count : ''}}" />
            </div>

            <div class="form-group mt-2">
                <label for="description">{{__('Opis')}}</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{isset($book->description) ? $book->description : ''}}</textarea>
            </div>

            <button type="submit" name="submit" value="1" class="btn btn-lg btn-outline-primary mt-3 d-block mx-auto">
                {{isset($book->id) ? __('Edytuj') : __('Dodaj') }}
            </button>
        </form>
    </div>
@endsection
