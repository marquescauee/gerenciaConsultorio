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
                <label for="name" class="form-label">name:</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" aria-describedby="name" required name="name" value="{{ $patient->name ?? old('name') }}">

                @error('name')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control  @error('email') is-invalid @enderror" id="email" aria-describedby="email" name="email" required value="{{ $patient->email ?? old('email') }}">

                @error('email')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="cpf" class="form-label">CPF:</label>
                <input type="text" class="form-control  @error('cpf') is-invalid @enderror" id="cpf" aria-describedby="cpf" name="cpf" required value="{{ $patient->cpf ?? old('cpf') }}">

                @error('cpf')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="cellphone" class="form-label">Telefone:</label>
                <input type="text" class="form-control  @error('cellphone') is-invalid @enderror" id="cellphone" aria-describedby="cellphone" name="cellphone" required value="{{ $patient->cellphone ?? old('cellphone') }}">

                @error('cellphone')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="birthday" class="form-label ">Data de Nascimento:</label>
                <input type="text" class="form-control @error('birthday') is-invalid @enderror" id="birthday" aria-describedby="birthday" name="birthday" placeholder="Formato dd/mm/YYYY" required value="{{ $patient->birthday ?? old('birthday') }}">

                @error('birthday')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="convenio" class="form-label ">Convênio:</label>

                <select name="convenio" id="convenio" class="form-select @error('convenio') is-invalid @enderror">
                    <option value="0">Não possuo convênio</option>
                    @foreach ($convenios as $convenio)
                        <option value="{{$convenio->id}}">{{$convenio->name}}</option>
                    @endforeach
                </select>

                @error('convenio')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Senha:</label>
                <input type="password" class="form-control  @error('password') is-invalid @enderror" id="password" aria-describedby="password" name="password"
                    required>

                @error('password')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Salvar</button>
        </form>
    </div>
@endsection
