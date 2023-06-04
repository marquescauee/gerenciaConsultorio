@extends('layouts.app')


@extends('layouts.__partials.sidebar')


@section('content')
    <style>
        .divCentral {
            margin-left: 25%;
        }
    </style>

    <div class="container mt-5 divCentral">
        <form action="{{route('specialities.update')}}" class="w-50 my-0" style="margin-left: 20%" method="post">
            @method("PUT")
            @csrf

            <input type="hidden" value="{{$speciality->id}}" name="id">

            <div class="mb-3">
                <label for="nome" class="form-label @error('nome') is-invalid @enderror">Nome:</label>
                <input type="text" class="form-control" id="nome" aria-describedby="nome" required value="{{$speciality->name}}" name="name">

                @error('nome')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Salvar</button>
        </form>
    </div>
@endsection
