@extends('layouts.app')


@extends('layouts.__partials.sidebar')


@section('content')
    <style>
        .divCentral {
            margin-left: 25%;
        }
    </style>

    <div class="container mt-5 divCentral">
        <form action="{{route('specialities.store')}}" class="w-50 my-0" style="margin-left: 20%" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label @error('name') is-invalid @enderror">name:</label>
                <input type="text" class="form-control" id="name" aria-describedby="name" required name="name" value="{{ $patient->name ?? old('name') }}">

                @error('name')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Salvar</button>
        </form>
    </div>
@endsection
