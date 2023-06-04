@extends('layouts.app')


@extends('layouts.__partials.sidebar')

@section('content')
    <style>
        table {
            margin: 0 auto;
            width: 50%;
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
            <a href="{{ route('specialities.create') }}">
                <img width="25" src="{{ asset('/img/icon/add.png') }}" alt="">
            </a>
        </div>

        <table className="table">
            <thead>
                <tr class="text-center">
                    <th>ID</th>
                    <th>Nome</th>
                </tr>
            </thead>
            <tbody
                @foreach ($specialities as $speciality)
                    <tr class="text-center border-bottom">
                        <td>
                            {{ $speciality->id }}
                        </td>
                        <td>
                            {{ $speciality->name }}
                        </td>
                        <td class="d-flex justify-content-center align-items-center gap-2">
                            <div class="subIcons">
                                <a href="">
                                    <img width="25" src="{{ asset('/img/icon/search.png') }}" alt="">
                                </a>
                            </div>
                            <div class="subIcons">
                                <a href="{{ url('specialities/edit/' . $speciality->id) }}">
                                    <img width="25" src="{{ asset('/img/icon/pencil.png') }}" alt="">
                                </a>
                            </div>
                            <div class="subIcons">
                                <form action="{{ url('specialities/delete/' . $speciality->id) }}" method="POST" class="my-0">
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
                    </tr> @endforeach
                </tbody>
        </table>
    </div>
@endsection
