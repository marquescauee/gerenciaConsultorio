@extends('layouts.app')


@extends('layouts.__partials.sidebar')


@section('content')
    <style>
        .divCentral {
            margin-left: 25%;
        }
    </style>

    <div class="container mt-5 divCentral">
        <form action="{{ route('suppliers.update') }}" class="w-50 my-0" style="margin-left: 20%" method="post">
            @method('PUT')
            @csrf

            <input type="hidden" value="{{ $supplier->id }}" name="id">

            <div class="mb-3">
                <label for="name" class="form-label ">Nome:</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    aria-describedby="name" required value="{{ $supplier->name }}" name="name">

                @error('name')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="text" class="form-control  @error('email') is-invalid @enderror" id="email"
                    aria-describedby="email" required value="{{ $supplier->email }}" name="email">

                @error('email')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="cellphone" class="form-label ">cellphone:</label>
                <input type="text" class="form-control @error('cellphone') is-invalid @enderror" id="cellphone"
                    aria-describedby="cellphone" required value="{{ $supplier->cellphone }}" name="cellphone">

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
