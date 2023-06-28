@extends('layouts.app')


@extends('layouts.__partials.sidebar')


@section('content')
    <style>
        .divCentral {
            margin-left: 25%;
        }

        .myCheck {
            font-size: 1.1rem;
        }
    </style>

    <div class="container mt-5 divCentral">
        <form action="{{ route('recipes.store') }}" class="w-50 my-0" style="margin-left: 20%" method="POST">
            @csrf

            @if (isset($errMessage))
                <div class="alert alert-danger mt-2">
                    {{ $errMessage }}
                </div>
            @endif

            <div class="mb-3">
                <label for="patient" class="form-label ">Paciente:</label>

                <select name="patient" id="patient" class="form-select @error('patient') is-invalid @enderror">
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                    @endforeach
                </select>

                <label class="form-label mt-3" for="presctiption">
                    Receita
                </label>
                <textarea name="prescription" class="form-control @error('prescription') is-invalid @enderror"
                                              id="prescription" rows="5" value="{{ $recipe->presctiption}}"></textarea>

                @error('patient')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Salvar</button>
        </form>
    </div>
@endsection
