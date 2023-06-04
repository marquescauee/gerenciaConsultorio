@extends('layouts.app')


@extends('layouts.__partials.sidebar')


@section('content')
    <style>
        .divCentral {
            margin-left: 25%;
        }
    </style>

    <div class="container mt-5 divCentral">
        <form action="{{route('patients.update')}}" class="w-50 my-0" style="margin-left: 20%" method="post">
            @method("PUT")
            @csrf

            <input type="hidden" value="{{$patient->id}}" name="id">

            <div class="mb-3">
                <label for="name" class="form-label @error('name') is-invalid @enderror">name:</label>
                <input type="text" class="form-control" id="name" aria-describedby="name" required value="{{$patient->name}}" name="name">

                @error('name')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label @error('email') is-invalid @enderror">Email:</label>
                <input type="text" class="form-control" id="email" aria-describedby="email" required value="{{$patient->email}}" name="email">

                @error('email')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="cellphone" class="form-label @error('cellphone') is-invalid @enderror">cellphone:</label>
                <input type="text" class="form-control" id="cellphone" aria-describedby="cellphone" required value="{{$patient->cellphone}}" name="cellphone">

                @error('cellphone')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="birthday" class="form-label @error('birthday') is-invalid @enderror">Data de Nascimento:</label>
                <input type="text" class="form-control" id="birthday" aria-describedby="birthday" required value="{{$patient->birthday}}" name="birthday">

                @error('birthday')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Salvar</button>
        </form>
    </div>
@endsection
