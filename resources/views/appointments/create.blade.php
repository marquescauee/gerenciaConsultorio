@extends('layouts.app')


@extends('layouts.__partials.sidebar')


@section('content')
    <style>
        .divCentral {
            margin-left: 25%;
        }
    </style>

    <div class="container mt-5 divCentral">
        <form action="{{ route('appointments.createSetDate') }}" class="w-50 my-0" style="margin-left: 20%" method="POST">
            @csrf

            <div class="mb-3">
                <label for="patient" class="form-label ">Paciente:</label>

                <select name="patient" id="patient" class="form-select @error('patient') is-invalid @enderror">
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                    @endforeach
                </select>

                @error('speciality')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="procedure" class="form-label ">Procedimento:</label>

                <select name="procedure" id="procedure" class="form-select @error('procedure') is-invalid @enderror">
                    @foreach ($procedures as $procedure)
                        <option value="{{ $procedure->id }}">{{ $procedure->description }}</option>
                    @endforeach
                </select>

                @error('procedure')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Continuar</button>
        </form>
    </div>
@endsection
