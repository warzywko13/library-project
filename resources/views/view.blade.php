@extends('layouts.app')

@section('content')
    <div class="container shadow pt-2 pb-5 px-2 rounded">
        <div class="row mt-5">
            <div class="col-4">
                <div class="container w-75">
                    @isset($book['image_id'])
                        <img class="img-fluid rounded" src="data:image/jpeg;base64,{{ $book['image_id'] }}" alt="{{ $book['name'] }}" />
                        <div class="mt-2">
                            <p class="fs-5 p-2">{{ __('Dostępna ilość') }}: {{$book['count']}}</p>
                        </div>
                    @endisset
                    <form method="POST" action="/book/reserve" onsubmit="return confirm('{{ __('Czy na pewno chcesz wypożyczyć?') }}')">
                        @csrf
                        <input type="hidden" value="{{ $book['id'] }}" />
                        <button class="btn btn-lg btn-outline-primary d-block mx-auto">{{ __('Wypożycz') }}</button>
                    </form>
                </div>
            </div>
            <div class="col-8">
                <h1 class="text-center fw-bolder w-100 border-bottom">{{ $book['name'] }}</h1>
                <p class="mt-2" style="white-space: pre-wrap; overflow-wrap: break-word;">{{ $book['description'] }}</p>
            </div>
        </div>
    </div>
@endsection
