@extends('layouts.app')


@extends('layouts.__partials.sidebar')


@section('content')
    <style>
        .divCentral {
            margin-left: 25%;
        }
    </style>

    <div class="container mt-5 divCentral">

        @if (isset($errorTime))
            <div class="alert alert-danger msgError">
                {{ $errorTime }}
            </div>
        @endif
        <form action="{{ route('appointments.setTime') }}" class="w-50 my-0" style="margin-left: 20%" method="POST">
            @csrf

            <input type="hidden" name="procedure" value="{{ $procedure }}">
            <input type="hidden" name="patient" value="{{ $patient }}">
            <input type="hidden" name="date" value="{{ $date }}">

            <div class="mb-3">
                <label for="time" class="form-label labelConsulta d-block">Horário:</label>

                @foreach ($hoursAvailable as $hour)
                    <div class="form-check mx-3 my-5" style="display: inline-block">
                        <input class="form-check-input" type="radio" name="time" value="{{ $hour }}">
                        <label class="form-check-label text-dark" for="flexRadioDefault">
                            {{ $hour }}
                        </label>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Continuar</button>
        </form>
    </div>
@endsection
