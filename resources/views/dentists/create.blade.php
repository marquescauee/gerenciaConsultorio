@extends('layouts.app')


@extends('layouts.__partials.sidebar')


@section('content')
    <style>
        .divCentral {
            margin-left: 25%;
        }
    </style>

    <div class="container mt-5 divCentral">
        <form action="{{ route('dentists.store') }}" class="w-50 my-0" style="margin-left: 20%" method="POST">
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

            <div class="mb-3">
                <label for="email" class="form-label @error('email') is-invalid @enderror">Email:</label>
                <input type="email" class="form-control" id="email" aria-describedby="email" name="email" required value="{{ $patient->email ?? old('email') }}">

                @error('email')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="CRO" class="form-label @error('CRO') is-invalid @enderror">CRO:</label>
                <input type="text" class="form-control" id="CRO" aria-describedby="CRO" name="CRO" required value="{{ $patient->CRO ?? old('CRO') }}" placeholder="formato XX-NNNNN">

                @error('CRO')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="speciality" class="form-label @error('speciality') is-invalid @enderror">Especialidade:</label>

                <select name="speciality" id="speciality" class="form-select">
                    @foreach ($specialities as $speciality)
                        <option value="{{$speciality->id}}">{{$speciality->name}}</option>
                    @endforeach
                </select>

                @error('speciality')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="cellphone" class="form-label @error('cellphone') is-invalid @enderror">Telefone:</label>
                <input type="text" class="form-control" id="cellphone" aria-describedby="cellphone" name="cellphone"
                    required value="{{ $patient->cellphone ?? old('cellphone') }}">

                @error('cellphone')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="birthday" class="form-label @error('birthday') is-invalid @enderror">Data de
                    Nascimento:</label>
                <input type="text" class="form-control"  placeholder="Formato dd/mm/YYYY" id="birthday" aria-describedby="birthday" name="birthday"
                    required value="{{ $patient->birthday ?? old('birthday') }}">

                @error('birthday')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label @error('password') is-invalid @enderror">Senha:</label>
                <input type="password" class="form-control" id="password" aria-describedby="password" name="password"
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
