@extends('layouts.app')


@extends('layouts.__partials.sidebar')


@section('content')
    <style>
        .divCentral {
            margin-left: 25%;
        }
    </style>

    <div class="container mt-5 divCentral">
        <form action="{{ route('appointments.store') }}" class="w-50 my-0" style="margin-left: 20%" method="POST">
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

            <div class="mb-3">
                <label for="date" class="form-label">Data de realização:</label>
                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                    aria-describedby="date" required name="date">

                @if (isset($errorDay))
                    <div class="alert alert-danger mt-2">
                        {{ $errorDay }}
                    </div>
                @endif

                @error('date')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="time" class="form-label">Horário (Entre 09:00 e 17:00):</label>
                <input type="time" class="form-control @error('time') is-invalid @enderror" id="time"
                    aria-describedby="time" required name="time" min="09:00" value="09:00" max="16:30"
                    step="1800">

                @if (isset($errorTime))
                    <div class="alert alert-danger mt-2">
                        {{ $errorTime }}
                    </div>
                @endif

                @error('time')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Salvar</button>
        </form>
    </div>
@endsection
