@extends('layouts.app')

@section('content')
    <div class="container shadow pt-2 pb-5 px-2 rounded">
        <div class="row mt-5">
            <div class="col-4">
                <div class="container w-75">
                    @isset($book['image_id'])
                        <img class="img-fluid rounded" src="data:image/jpeg;base64,{{ $book['image_id'] }}" alt="{{ $book['name'] }}" />
                    @endisset
                    <form method="POST" class="form-group row mt-2" action="/book/reserve" onsubmit="return confirm('{{ __('Czy na pewno chcesz wypożyczyć?') }}')">
                        @csrf
                        <input type="hidden" name="id" value="{{ $book['id'] }}" />

                        <!-- Od -->
                        <label for="from" class="col-sm-2 col-form-label">{{ __('Od') }}</label>
                        <div class="col-sm-10">
                            <input required type="date" class="form-control" id="from" name="from" />
                            @isset($error['from'])
                                <div class="text-danger fw-bold">
                                   {{ $error['from'] }}
                                </div>
                            @endisset
                        </div>

                        <!-- Do -->
                        <label for="to" class="col-sm-2 col-form-label mt-2">{{ __('Do') }}</label>
                        <div class="col-sm-10">
                            <input required type="date" class="form-control mt-2" id="to" name="to" />
                            @isset($error['to'])
                                <div class="text-danger fw-bold">
                                    {{ $error['to'] }}
                                </div>
                            @endisset
                        </div>


                        <button class="btn btn-lg btn-outline-primary d-block mx-auto mt-2">{{ __('Wypożycz') }}</button>

                        @isset($error['form'])
                            <div class="text-danger fw-bold">
                                {{ $error['form'] }}
                            </div>
                        @endisset
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
