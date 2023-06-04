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
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" aria-describedby="email" name="email" required value="{{ $patient->email ?? old('email') }}">

                @error('email')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="CRO" class="form-label">CRO:</label>
                <input type="text" class="form-control  @error('CRO') is-invalid @enderror" id="CRO" aria-describedby="CRO" name="CRO" required value="{{ $patient->CRO ?? old('CRO') }}" placeholder="formato XX-NNNNN">

                @error('CRO')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="speciality" class="form-label ">Especialidade:</label>

                <select name="speciality" id="speciality" class="form-select @error('speciality') is-invalid @enderror">
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
                <label for="cellphone" class="form-label">Telefone:</label>
                <input type="text" class="form-control  @error('cellphone') is-invalid @enderror" id="cellphone" aria-describedby="cellphone" name="cellphone"
                    required value="{{ $patient->cellphone ?? old('cellphone') }}">

                @error('cellphone')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="birthday" class="form-label ">Data de
                    Nascimento:</label>
                <input type="text" class="form-control @error('birthday') is-invalid @enderror"  placeholder="Formato dd/mm/YYYY" id="birthday" aria-describedby="birthday" name="birthday"
                    required value="{{ $patient->birthday ?? old('birthday') }}">

                @error('birthday')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label ">Senha:</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" aria-describedby="password" name="password"
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
