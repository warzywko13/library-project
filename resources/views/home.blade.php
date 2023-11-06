@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 d-flex flex-wrap gap-4">
            @if($books)
                @foreach($books as $book)
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <img class="card-img-top" data-src="holder.js/100px180/" alt="100%x180" style="height: 180px; width: 100%; display: block;" @isset($book->image) src="data:image/jpeg;base64,{{ $book->image }}" @endisset data-holder-rendered="true">
                            <h5 class="card-title pt-4">{{ $book->name }}</h5>
                            <p class="card-text">Ilość: {{ $book->count }}</p>
                            <a href="/book/view/{{ $book->id }}" class="btn btn-primary">Czytaj więcej</a>
                        </div>
                    </div>
                @endforeach
            @else
                <div>{{ __('Brak książęk :/') }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
