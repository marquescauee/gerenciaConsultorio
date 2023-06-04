@extends('layouts.app')


@extends('layouts.__partials.sidebar')


@section('content')
    <style>
        .divCentral {
            margin-left: 25%;
        }
    </style>

    <div class="container mt-5 divCentral">
        <form action="{{ route('dentists.update') }}" class="w-50 my-0" style="margin-left: 20%" method="post">
            @method('PUT')
            @csrf

            <input type="hidden" value="{{ $dentist->id }}" name="id">

            <div class="mb-3">
                <label for="name" class="form-label @error('name') is-invalid @enderror">name:</label>
                <input type="text" class="form-control" id="name" aria-describedby="name" required
                    value="{{ $dentist->name }}" name="name">

                @error('name')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label @error('email') is-invalid @enderror">Email:</label>
                <input type="text" class="form-control" id="email" aria-describedby="email" required
                    value="{{ $dentist->email }}" name="email">

                @error('email')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="speciality" class="form-label @error('speciality') is-invalid @enderror">Especialidade:</label>

                <select name="speciality" id="speciality" class="form-select">
                    @foreach ($specialities as $speciality)
                        @if ($speciality->id == $dentist->speciality_id)
                            <option value="{{ $speciality->id }}" selected>{{ $speciality->name }}</option>
                        @else
                            <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                        @endif
                    @endforeach
                </select>

                @error('speciality')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="cellphone" class="form-label @error('cellphone') is-invalid @enderror">cellphone:</label>
                <input type="text" class="form-control" id="cellphone" aria-describedby="cellphone" required
                    value="{{ $dentist->cellphone }}" name="cellphone">

                @error('cellphone')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="birthday" class="form-label @error('birthday') is-invalid @enderror">Data de
                    Nascimento:</label>
                <input type="text" class="form-control" id="birthday" aria-describedby="birthday" required
                    value="{{ $dentist->birthday }}" name="birthday">

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
