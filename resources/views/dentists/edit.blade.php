@extends('layouts.app')


@extends('layouts.__partials.sidebar')


@section('content')
    <style>
        .divCentral {
            margin-left: 25%;
        }
    </style>

    <div class="container mt-5 divCentral">
        <form action="{{route('dentists.update')}}" class="w-50 my-0" style="margin-left: 20%" method="post">
            @method("PUT")
            @csrf

            <input type="hidden" value="{{$dentist->id}}" name="id">

            <div class="mb-3">
                <label for="nome" class="form-label @error('nome') is-invalid @enderror">Nome:</label>
                <input type="text" class="form-control" id="nome" aria-describedby="nome" required value="{{$dentist->name}}" name="name">

                @error('nome')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label @error('email') is-invalid @enderror">Email:</label>
                <input type="text" class="form-control" id="email" aria-describedby="email" required value="{{$dentist->email}}" name="email">

                @error('email')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="telefone" class="form-label @error('telefone') is-invalid @enderror">Telefone:</label>
                <input type="telefone" class="form-control" id="telefone" aria-describedby="telefone" required value="{{$dentist->cellphone}}" name="cellphone">

                @error('telefone')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="data_nasc" class="form-label @error('data_nasc') is-invalid @enderror">Data de Nascimento:</label>
                <input type="text" class="form-control" id="data_nasc" aria-describedby="data_nasc" required value="{{$dentist->birthday}}" name="birthday">

                @error('data_nasc')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Salvar</button>
        </form>
    </div>
@endsection
