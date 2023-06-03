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

        .botaoAdd {
            position: absolute;
            top: 15%;
            left: 17%;
        }
    </style>

    <div class="botaoAdd">
        <a href="">
            <img width="25" src="{{ asset('/img/icon/add.png') }}" alt="">
        </a>
    </div>

    <table className="table">
        <thead>
            <tr class="text-center">
                <th>Nome</th>
                <th>CPF</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody
            @foreach ($patients as $patient)
                <tr class="text-center border-bottom">
                    <td>
                        {{ $patient->name }}
                    </td>
                    <td>
                        {{ $patient->email }}
                    </td>
                    <td class="d-flex justify-content-center align-items-center gap-2">
                        <div class="subIcons">
                            <a href="">
                                <img width="25" src="{{ asset('/img/icon/search.png') }}" alt="">
                            </a>
                        </div>
                        <div class="subIcons">
                            <a href="">
                                <img width="25" src="{{ asset('/img/icon/pencil.png') }}" alt="">
                            </a>
                        </div>
                        <div class="subIcons">
                            <a href="">
                                <img width="25" src="{{ asset('/img/icon/trash.png') }}" alt="">
                            </a>
                        </div>
                    </td>
                </tr> @endforeach
            </tbody>
    </table>
@endsection
