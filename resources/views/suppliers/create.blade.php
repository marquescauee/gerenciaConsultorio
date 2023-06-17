@extends('layouts.app')


@extends('layouts.__partials.sidebar')


@section('content')
    <style>
        .divCentral {
            margin-left: 25%;
        }
    </style>

    <div class="container mt-5 divCentral">
        <form action="{{route('suppliers.store')}}" class="w-50 my-0" style="margin-left: 20%" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nome:</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" aria-describedby="name" required name="name" value="{{ $supplier->name ?? old('name') }}">

                @error('name')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="cnpj" class="form-label">CNPJ:</label>
                <input type="text" class="form-control  @error('cnpj') is-invalid @enderror" id="cnpj" aria-describedby="cnpj" name="cnpj" required value="{{ $supplier->cnpj ?? old('cnpj') }}">

                @error('cnpj')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control  @error('email') is-invalid @enderror" id="email" aria-describedby="email" name="email" required value="{{ $supplier->email ?? old('email') }}">

                @error('email')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="cellphone" class="form-label">Telefone:</label>
                <input type="text" class="form-control  @error('cellphone') is-invalid @enderror" id="cellphone" aria-describedby="cellphone" name="cellphone" required value="{{ $supplier->cellphone ?? old('cellphone') }}">

                @error('cellphone')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Salvar</button>
        </form>
    </div>
@endsection
