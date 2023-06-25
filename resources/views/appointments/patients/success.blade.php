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

        .bg {
            background-color: black;
        }

        .myCard {
            width: 40rem;
            height: 30rem;
            text-align: center;
            background-color: black;
            color: white;
            box-shadow: 10px 5px 5px black;
            position: absolute;
            top: 30%;
            left: 20%;
        }

        .myCardSize {
            font-size: 1.5rem;
        }

        .myCardBody {
            font-size: 1.3rem;
            text-align: start;
            gap: 3rem;
            margin-top: 3rem;
        }
    </style>

    <div class="container mt-5 divCentral">
        <div class="card myCard">
            <div class="card-header myCardSize">
                Consulta Cadastrada com Sucesso! <br>
                <div class="mt-4">
                    Enviamos um email com estas informações para você anotar!
                </div>
            </div>
            <ul class="list-group list-group-flush myCardBody">
                <li class="list-group-item bg text-light">Dentista: {{ $dentist->name }}</li>
                <li class="list-group-item bg text-light">Procedimento: {{ $procedure }}</li>
                <li class="list-group-item bg text-light">Horário: {{ $date }} - {{ $time }}</li>
            </ul>
        </div>
    </div>
@endsection
