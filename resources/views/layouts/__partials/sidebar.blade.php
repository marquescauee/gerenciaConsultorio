<style>
    .mainDiv {
        width: 15%;
        position: absolute;
        top: 0;
        z-index: 1;
    }

    .iconSize {
        width: 60px;
    }

    .subIconsSize {
        width: 50px;
    }

    .divSubItems {
        gap: 35px;
        margin-bottom: 20px;
    }

    .botoes {
        background: none;
        border: none;
        padding: 0px;
    }
</style>

<div style="background-color: #66737e;" class="d-flex mainDiv h-100">
    <ul class="d-flex mt-4">
        <li class="d-flex flex-column gap-2">

            <div class="d-flex align-items-center gap-4">
                <div class="row d-flex iconSize">
                    <img src="{{ asset('/img/icon/tooth.png') }}" alt="">
                </div>
                <a class="d-flex text-decoration-none text-light" href="{{ route('home') }}">Gerência Consultório</a>
            </div>


            @php
                $user = DB::table('users')
                    ->join('dentists', 'dentists.id', 'users.id')
                    ->where('dentists.id', Auth::user()->id)
                    ->first();
            @endphp

            @if ($user->admin)
                <div class="d-flex align-items-center gap-4 mt-3">
                    <div class="row d-flex iconSize">
                        <img src="{{ asset('/img/icon/user.png') }}" alt="">
                    </div>
                    <a class="d-flex text-decoration-none text-light" href="#">Administrador</a>
                </div>
            @else
                <div class="d-flex align-items-center gap-4 mt-3">
                    <div class="row d-flex iconSize">
                        <img src="{{ asset('/img/icon/user.png') }}" alt="">
                    </div>
                    <a class="d-flex text-decoration-none text-light" href="#">Dentista</a>
                </div>
            @endif

            {{-- <div class="d-flex align-items-center divSubItems mt-3">
                <div class="row d-flex subIconsSize">
                    <img src="{{ asset('/img/icon/medal.png') }}" alt="">
                </div>
                <a class="d-flex text-decoration-none text-light" href="{{ route('suppliers.index') }}">Fornecedores</a>
            </div> --}}

            @if ($user->admin)
                <div class="d-flex align-items-center divSubItems mt-3">
                    <div class="row d-flex subIconsSize">
                        <img src="{{ asset('/img/icon/dentist.png') }}" alt="">
                    </div>
                    <a class="d-flex text-decoration-none text-light" href="{{ route('dentists.index') }}">Dentistas</a>
                </div>

                <div class="d-flex align-items-center divSubItems">
                    <div class="row d-flex subIconsSize">
                        <img src="{{ asset('/img/icon/multiUser.png') }}" alt="">
                    </div>
                    <a class="d-flex text-decoration-none text-light" href="{{ route('home') }}">Pacientes</a>
                </div>

                <div class="d-flex align-items-center divSubItems">
                    <div class="row d-flex subIconsSize">
                        <img src="{{ asset('/img/icon/calendario.png') }}" alt="">
                    </div>
                    <a class="d-flex text-decoration-none text-light" href="{{ route('agendas.index') }}">Agendas</a>
                </div>

                <div class="d-flex align-items-center divSubItems">
                    <div class="row d-flex subIconsSize">
                        <img src="{{ asset('/img/icon/especialidade.png') }}" alt="">
                    </div>
                    <a class="d-flex text-decoration-none text-light"
                        href="{{ route('specialities.index') }}">Especialidades</a>
                </div>

                <div class="d-flex align-items-center divSubItems">
                    <div class="row d-flex subIconsSize">
                        <img src="{{ asset('/img/icon/search.png') }}" alt="">
                    </div>
                    <a class="d-flex text-decoration-none text-light"
                        href="{{ route('appointments.index') }}">Agendamentos</a>
                </div>

                <div class="d-flex align-items-center divSubItems">
                    <div class="row d-flex subIconsSize">
                        <img src="{{ asset('/img/icon/receita.png') }}" alt="">
                    </div>
                    <a class="d-flex text-decoration-none text-light"
                        href="{{ route('recipes.index') }}">Receitas</a>
                </div>

                <div class="d-flex align-items-center divSubItems">
                    <div class="row d-flex subIconsSize">
                        <img src="{{ asset('/img/icon/medicines.png') }}" alt="">
                    </div>
                    <a class="d-flex text-decoration-none text-light" href="#">Medicamentos</a>
                </div>

                <div class="d-flex align-items-center divSubItems">
                    <div class="row d-flex subIconsSize">
                        <img src="{{ asset('/img/icon/robotic-surgery.png') }}" alt="">
                    </div>
                    <a class="d-flex text-decoration-none text-light"
                        href="{{ route('procedures.index') }}">Procedimentos</a>
                </div>

                <div class="d-flex align-items-center divSubItems">
                    <div class="row d-flex subIconsSize">
                        <img src="{{ asset('/img/icon/heart.png') }}" alt="">
                    </div>
                    <a class="d-flex text-decoration-none text-light" href="{{ route('plans.index') }}">Convênios</a>
                </div>

                <div class="d-flex align-items-center divSubItems">
                    <div class="row d-flex subIconsSize">
                        <img src="{{ asset('/img/icon/atestado.png') }}" alt="">
                    </div>
                    <a class="d-flex text-decoration-none text-light" href="#">Atestados</a>
                </div>
                <div class="d-flex align-items-center divSubItems">
                    <div class="row d-flex subIconsSize">
                        <img src="{{ asset('/img/icon/trend.png') }}" alt="">
                    </div>
                    <a class="d-flex text-decoration-none text-light" href="#">Relatórios</a>
                </div>


                <div class="d-flex" style="margin-top: 50px">
                    <div class="d-flex gap-2 flex-column">
                        <div class="d-flex align-items-center divSubItems">
                            <div class="row d-flex subIconsSize">
                                <img src="{{ asset('/img/icon/settings.png') }}" alt="">
                            </div>
                            <a class="d-flex text-decoration-none text-light" href="#">Ajustes</a>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <div class="d-flex align-items-center divSubItems">
                                <button class="botoes row d-flex subIconsSize">
                                    <img src="{{ asset('/img/icon/power.png') }}" alt="">
                                </button>
                                <button class="botoes my-0 d-flex text-decoration-none text-light">Sair</button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="d-flex align-items-center divSubItems mt-5">
                    <div class="row d-flex subIconsSize">
                        <img src="{{ asset('/img/icon/search.png') }}" alt="">
                    </div>
                    <a class="d-flex text-decoration-none text-light"
                        href="{{ route('appointments.index') }}">Agendamentos</a>
                </div>

                <div class="d-flex align-items-center divSubItems">
                    <div class="row d-flex subIconsSize">
                        <img src="{{ asset('/img/icon/atestado.png') }}" alt="">
                    </div>
                    <a class="d-flex text-decoration-none text-light" href="#">Atestados</a>
                </div>

                <div class="d-flex align-items-center divSubItems">
                    <div class="row d-flex subIconsSize">
                        <img src="{{ asset('/img/icon/receita.png') }}" alt="">
                    </div>
                    <a class="d-flex text-decoration-none text-light" href="{{ route('recipes.index') }}">Receitas</a>
                </div>

                <div class="d-flex" style="margin-top: 450px">
                    <div class="d-flex gap-2 flex-column">
                        <div class="d-flex align-items-center divSubItems">
                            <div class="row d-flex subIconsSize">
                                <img src="{{ asset('/img/icon/settings.png') }}" alt="">
                            </div>
                            <a class="d-flex text-decoration-none text-light" href="#">Ajustes</a>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <div class="d-flex align-items-center divSubItems">
                                <button class="botoes row d-flex subIconsSize">
                                    <img src="{{ asset('/img/icon/power.png') }}" alt="">
                                </button>
                                <button class="botoes my-0 d-flex text-decoration-none text-light">Sair</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

        </li>
    </ul>
</div>
