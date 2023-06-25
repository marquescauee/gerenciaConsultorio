@extends('layouts.home')

@section('content')
    <style>
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

        body, main {
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
    </style>

    <div class="container my-5">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('img/img1.jpg') }}" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/img2.jpg') }}" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/img3.jpg') }}" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div>
            <a class="botaoConsulta" href="{{route('appointments.patients.create')}}">
                Marque Sua Consulta!
            </a>
        </div>
    </div>

    <div class="d-flex justify-content-evenly align-items-center " style="margin: 100px 0px; font-size: 20px;">
        <div class="card"
            style="width: 30rem; text-align: center; background-color: black; color: white; box-shadow: 10px 5px 5px black;">
            <img src="{{ asset('img/img4.jpg') }}" class="card-img-top" alt="...">
            <div class="card-body">
                <p class="card-text">Temos os melhores profissionais da região e possuímos um controle de qualidade rigoroso
                    em nosso atendimento, visando o bem-estar do cliente.</p>
            </div>
        </div>

        <div class="card"
            style="width: 30rem;  text-align: center; background-color: black; color: white; box-shadow: 10px 5px 5px black;">
            <img src="{{ asset('img/img5.jpg') }}" class="card-img-top" alt="...">
            <div class="card-body">
                <p class="card-text">Enquanto a sua vez não chega, você pode aguardar em nosso espaço disponível
                    para você.</p>
            </div>
        </div>

        <div class="card"
            style="width: 30rem; text-align: center; background-color: black; color: white; box-shadow: 10px 5px 5px black;">
            <img src="{{ asset('img/img6.png') }}" class="card-img-top" alt="...">
            <div class="card-body">
                <p class="card-text">Nossos ambientes de trabalho são modernos e contam com ótimos equipamentos de marcas referência no mercado.</p>
            </div>
        </div>
    </div>

@endsection
