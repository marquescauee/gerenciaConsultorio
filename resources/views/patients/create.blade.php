@extends('layouts.app')


@extends('layouts.__partials.sidebar')


@section('content')
    <style>
        .divCentral {
            margin-left: 25%;
        }
    </style>

    <div class="container mt-5 divCentral">
        <form action="{{route('patients.store')}}" class="w-50 my-0" style="margin-left: 20%" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nome" class="form-label @error('nome') is-invalid @enderror">Nome:</label>
                <input type="text" class="form-control" id="nome" aria-describedby="nome" required name="nome">

                @error('nome')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label @error('email') is-invalid @enderror">Email:</label>
                <input type="email" class="form-control" id="email" aria-describedby="email" name="email" required>

                @error('email')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="cpf" class="form-label @error('cpf') is-invalid @enderror">CPF:</label>
                <input type="text" class="form-control" id="cpf" aria-describedby="cpf" name="cpf" required>

                @error('cpf')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="telefone" class="form-label @error('telefone') is-invalid @enderror">Telefone:</label>
                <input type="telefone" class="form-control" id="telefone" aria-describedby="telefone" name="telefone" required>

                @error('telefone')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="data_nasc" class="form-label @error('data_nasc') is-invalid @enderror">Data de Nascimento:</label>
                <input type="text" class="form-control" id="data_nasc" aria-describedby="data_nasc" name="data_nasc" required>

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
