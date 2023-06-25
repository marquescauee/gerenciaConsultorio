@extends('layouts.app')


@extends('layouts.__partials.sidebar')


@section('content')
    <style>
        .divCentral {
            margin-left: 25%;
        }
    </style>

    <div class="container mt-5 divCentral">
        <form action="{{ route('appointments.setDate') }}" class="w-50 my-0" style="margin-left: 20%" method="POST">
            @csrf

            <input type="hidden" name="procedure" value="{{$procedure}}">
            <input type="hidden" name="patient" value="{{$patient}}">

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

            <button type="submit" class="btn btn-primary w-100 mt-3">Continuar</button>
        </form>
    </div>
@endsection
