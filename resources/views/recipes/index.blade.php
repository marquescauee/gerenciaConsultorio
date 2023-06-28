@extends('layouts.app')


@extends('layouts.__partials.sidebar')

@section('content')
    <style>
        table {
            margin: 0 auto;
            width: 75%;
            position: absolute;
            top: 20%;
            left: 60%;
            transform: translateX(-50%);

            border-collapse: separate;
            border-spacing: 20px;
        }

        .subIcons {
            width: 35px;
        }

        .margem {
            margin-left: 15rem;
        }
    </style>

    <div class="container">
        <div class="mt-3">
            <a href="{{ route('recipes.create') }}">
                <img width="25" src="{{ asset('/img/icon/add.png') }}" alt="">
            </a>
        </div>

        @if (isset($errMessage))
            <div class="alert alert-danger mt-2 margem">
                {{ $errMessage }}
            </div>
        @endif

        <table className="table">
            <thead>
                <tr class="text-center">
                    <th>Nome do Paciente</th>
                    <th>Descrição</th>
                    <th>Nome do Dentista</th>
                    <th>Email</td>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody
                @foreach ($recipes as $recipe)
                    <tr class="text-center border-bottom">
                        <td>
                            {{ $recipe->patient_name}}
                        </td>
                        <td>
                            {{ $recipe->prescription}}
                        </td>
                        <td>
                            {{ $recipe->name }}
                        </td>
                        <td>
                            {{ $recipe->email }}
                        </td>

                    <td class="d-flex justify-content-center align-items-center gap-2">
                        <div class="subIcons">
                            <form action="{{ url('recipes/delete/' . $recipe->id) }}" method="POST" class="my-0">
                                @method('DELETE')
                                @csrf
                                <div class="my-0">
                                    <button class="border-0 bg-transparent">
                                        <img width="25" src="{{ asset('/img/icon/trash.png') }}" alt="">
                                    </button>
                                </div>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
