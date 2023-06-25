@extends('layouts.home')


@section('content')
    <style>
        .divCentral {
            position: absolute;
            top: 20%;
            left: 20%;
        }

        body,
        main,
        nav {
            background: #141E30;
            /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #243B55, #141E30);
            /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #243B55, #141E30);
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }

        body,
        main {
            overflow: auto;
        }


        .botaoConsulta {
            display: flex;
            width: 50%;
            justify-content: center;
            align-items: center;
            margin: 3rem auto;
            border: none;
            background: lightblue;
            height: 70px;
            font-weight: bold;
            font-size: 1.3rem;
            border-radius: 4px;
            text-decoration: none;
            color: black
        }

        .labelConsulta {
            color: white
        }
    </style>

    <div class="container mt-5 divCentral">
        <form action="{{ route('appointments.patients.setDentist') }}" class="w-50 my-0" style="margin-left: 20%" method="POST">
            @csrf

            <input type="hidden" name="procedure" value="{{ $procedure }}">

            <div class="mb-3">
                <label for="dentist" class="form-label labelConsulta">Dentista:</label>

                <select name="dentist" id="dentist" class="form-select @error('dentist') is-invalid @enderror">
                    @foreach ($dentists as $dentist)
                        <option value="{{ $dentist->id }}">{{ $dentist->name }}</option>
                    @endforeach
                </select>

                @error('dentist')
                    <span class="invalid-feedback align" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Continuar</button>
        </form>
    </div>
@endsection
