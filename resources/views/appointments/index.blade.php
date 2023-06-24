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


    </style>

    <div class="container">
        <div class="mt-3">
            <a href="{{ route('appointments.create') }}">
                <img width="25" src="{{ asset('/img/icon/add.png') }}" alt="">
            </a>
        </div>

        <table className="table">
            <thead>
                <tr class="text-center">
                    <th>Paciente</th>
                    <th>Data</th>
                    <th>Operação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody
                @foreach ($appointments as $appointment)
                    <tr class="text-center border-bottom">
                        <td>
                            {{ $appointment->name }}
                        </td>
                        <td>
                            {{ $appointment->description }}
                        </td>
                        <td>
                            {{ $appointment->date }}
                        </td>
                        <td class="d-flex justify-content-center align-items-center gap-2">
                            <div class="subIcons">
                                <a href="">
                                    <img width="25" src="{{ asset('/img/icon/search.png') }}" alt="">
                                </a>
                            </div>
                            {{-- <div class="subIcons">
                                <a href="{{url("appointments/edit/".$appointment->id)}}">
                                    <img width="25" src="{{ asset('/img/icon/pencil.png') }}" alt="">
                                </a>
                            </div> --}}
                            <div class="subIcons">
                                <form action="{{ url("appointments/delete/".$appointment->id) }}" method="POST" class="my-0">
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
