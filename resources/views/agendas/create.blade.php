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
        <form action="{{ route('agendas.store') }}" class="w-50 my-0" style="margin-left: 20%" method="POST">
            @csrf

            @if (isset($errMessage))
                <div class="alert alert-danger mt-2">
                    {{ $errMessage }}
                </div>
            @endif

            <div class="mb-3">
                <label for="dentist" class="form-label ">Dentista:</label>

                <select name="dentist" id="dentist" class="form-select @error('dentist') is-invalid @enderror">
                    @foreach ($dentists as $dentist)
                        <option value="{{ $dentist->id }}">{{ $dentist->name }}</option>
                    @endforeach
                </select>

                <div class="mt-5">
                    <h6>Selecione os dias de Trabalho:</h6>
                </div>

                <div class="form-check mt-3 myCheck">
                    <input class="form-check-input" type="checkbox" id="Monday" value="Monday" name="Monday">
                    <label class="form-check-label" for="Monday">
                        Segunda-Feira
                    </label>
                </div>

                <div class="form-check mt-3 myCheck">
                    <input class="form-check-input" type="checkbox" id="Tuesday" name="Tuesday" value="Tuesday">
                    <label class="form-check-label" for="Tuesday">
                        Terça-Feira
                    </label>
                </div>

                <div class="form-check mt-3 myCheck">
                    <input class="form-check-input" type="checkbox" value="Wednesday" id="Wednesday" name="Wednesday">
                    <label class="form-check-label" for="Wednesday">
                        Quarta-Feira
                    </label>
                </div>

                <div class="form-check mt-3 myCheck">
                    <input class="form-check-input" type="checkbox" value="Thursday" id="Thursday" name="Thursday">
                    <label class="form-check-label" for="Thursday">
                        Quinta-Feira
                    </label>
                </div>

                <div class="form-check mt-3 myCheck">
                    <input class="form-check-input" type="checkbox" value="Friday" id="Friday" name="Friday">
                    <label class="form-check-label" for="Friday">
                        Sexta-Feira
                    </label>
                </div>

                @error('dentist')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Salvar</button>
        </form>
    </div>
@endsection
