@extends('layouts.app')

@section('content')
    <div class="container">

        <h1 class="text-center fw-bold py-2">@isset($book['id']) {{ __('Edytuj książkę') }} @else {{ __('Dodaj książkę') }} @endisset</h1>

        <form method="POST" action="/admin/addedit" enctype="multipart/form-data">
            @csrf
            <input name="id" type="hidden" value="@isset($book['id']) {{ $book['id'] }} @endisset" />

            <div class="form-group">
                <label for="name">{{__('Nazwa')}}</label>
                <input required type="string" class="form-control" name="name" id="name" value="@isset($book['name']) {{ $book['name'] }} @endisset" />
                @isset($error['name'])
                    <p class="text-danger fw-bold">{{ $error['name'] }}</p>
                @endisset
            </div>

            <div class="form-group mt-2">
                <label for="count">{{__('Ilość')}}</label>
                <input required type="number" class="form-control" id="count" name="count" value="{{ $book['count'] }}" />
                @isset($error['count'])
                    <p class="text-danger fw-bold">{{ $error['count'] }}</p>
                @endisset
            </div>

            <div class="form-group mt-2">
                <label for="description">{{ __('Opis') }}</label>
                <textarea required class="form-control" id="description" name="description" rows="3">@isset($book['description']) {{ $book['description'] }} @endisset</textarea>
                @isset($error['description'])
                    <p class="text-danger fw-bold">{{ $error['description'] }}</p>
                @endisset
            </div>

            <div class="form-group mt-2">
                <label class="custom-file-label" for="image"> {{ __('Zdjęcie') }} </label>
                <div id="image"">
                    @isset($book['data_image'])
                        <img class="mb-3" style="width: 15rem; height: 15rem;" src="data:image/jpeg;base64,{{$book['data_image']}}" />
                    @endisset
                    <input type="file" name="image" class="form-control custom-file-input">
                </div>
            </div>

            <button type="submit" name="submit" value="1" class="btn btn-lg btn-outline-primary mt-3 d-block mx-auto">
                @isset($book['id']) {{ __('Edytuj') }} @else {{ __('Dodaj') }} @endisset
            </button>
        </form>
    </div>
@endsection
