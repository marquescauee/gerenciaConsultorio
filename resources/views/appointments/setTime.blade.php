@extends('layouts.app')


@extends('layouts.__partials.sidebar')


@section('content')
    <style>
        .divCentral {
            margin-left: 25%;
        }
    </style>

    <div class="container mt-5 divCentral">
        <form action="{{ route('appointments.setTime') }}" class="w-50 my-0" style="margin-left: 20%" method="POST">
            @csrf

            <input type="hidden" name="procedure" value="{{$procedure}}">
            <input type="hidden" name="patient" value="{{$patient}}">
            <input type="hidden" name="date" value="{{$date}}">

            <div class="mb-3">
                <label for="time" class="form-label">Horário (Entre 09:00 e 17:00):</label>
                <input type="time" class="form-control @error('time') is-invalid @enderror" id="time"
                    aria-describedby="time" required name="time" min="09:00" value="09:00" max="17:00"
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

            <button type="submit" class="btn btn-primary w-100 mt-3">Continuar</button>
        </form>
    </div>
@endsection
