@extends('layouts.app')


@extends('layouts.__partials.sidebar')


@section('content')
    <style>
        .divCentral {
            margin-left: 25%;
        }
    </style>

    <div class="container mt-5 divCentral">
        <form action="{{ route('procedures.update') }}" class="w-50 my-0" style="margin-left: 20%" method="post">
            @method('PUT')
            @csrf

            <input type="hidden" value="{{ $procedure->id }}" name="id">

            <div class="mb-3">
                <label for="description" class="form-label ">description:</label>
                <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" aria-describedby="description" required
                    value="{{ $procedure->description }}" name="description">

                @error('description')
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

            <button type="submit" class="btn btn-primary w-100 mt-3">Salvar</button>
        </form>
    </div>
@endsection
