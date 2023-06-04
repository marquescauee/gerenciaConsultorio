@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header text-center h2">{{ __('Cadastre-se') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-3 col-form-label text-md-end">{{ __('Nome') }}</label>

                                <div class="col-md-7">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-3 col-form-label text-md-end">{{ __('Email') }}</label>

                                <div class="col-md-7">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="cpf" class="form-label col-md-3 col-form-label text-md-end">CPF:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control @error('cpf') is-invalid @enderror"
                                        id="cpf" aria-describedby="cpf" name="cpf" required
                                        value="{{ $patient->cpf ?? old('cpf') }}">

                                    @error('cpf')
                                        <span class="invalid-feedback align" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="cellphone"
                                    class="form-label col-md-3 col-form-label text-md-end ">Telefone:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control @error('cellphone') is-invalid @enderror"
                                        id="cellphone" aria-describedby="cellphone" name="cellphone" required
                                        value="{{ $patient->cellphone ?? old('cellphone') }}">

                                    @error('cellphone')
                                        <span class="invalid-feedback align" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="birthday" class="form-label col-md-3 col-form-label text-md-end">Data de
                                    Nascimento:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control @error('birthday') is-invalid @enderror"
                                        id="birthday" aria-describedby="birthday" name="birthday"
                                        placeholder="Formato dd/mm/YYYY" required
                                        value="{{ $patient->birthday ?? old('birthday') }}">

                                    @error('birthday')
                                        <span class="invalid-feedback align" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-3 col-form-label text-md-end">{{ __('Senha') }}</label>

                                <div class="col-md-7">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-3 col-form-label text-md-end">{{ __('Confirme a Senha') }}</label>

                                <div class="col-md-7">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="mx-auto w-75 text-center">
                                    <button type="submit" class="btn btn-primary w-100">
                                        {{ __('Entrar') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
