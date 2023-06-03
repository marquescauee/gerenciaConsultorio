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

    .spacingPowerAdjust {
        margin-top: 200px;
    }

    .botoes {
        background: none;
        border: none;
        padding: 0px;
    }
</style>

<div style="background-color: #66737e;" class="d-flex mainDiv h-100">
    <ul class="d-flex mt-4">
        <li class="d-flex flex-column gap-3">

            <div class="d-flex align-items-center gap-4">
                <div class="row d-flex iconSize">
                    <img src="{{ asset('/img/icon/tooth.png') }}" alt="">
                </div>
                <a class="d-flex text-decoration-none text-light" href="#">Gerência Consultório</a>
            </div>


            <div class="d-flex align-items-center gap-4 mt-3">
                <div class="row d-flex iconSize">
                    <img src="{{ asset('/img/icon/user.png') }}" alt="">
                </div>
                <a class="d-flex text-decoration-none text-light" href="#">Administrador</a>
            </div>

            <div class="d-flex align-items-center divSubItems mt-3">
                <div class="row d-flex subIconsSize">
                    <img src="{{ asset('/img/icon/medal.png') }}" alt="">
                </div>
                <a class="d-flex text-decoration-none text-light" href="#">Fornecedores</a>
            </div>

            <div class="d-flex align-items-center divSubItems">
                <div class="row d-flex subIconsSize">
                    <img src="{{ asset('/img/icon/dentist.png') }}" alt="">
                </div>
                <a class="d-flex text-decoration-none text-light" href="#">Doutores</a>
            </div>

            <div class="d-flex align-items-center divSubItems">
                <div class="row d-flex subIconsSize">
                    <img src="{{ asset('/img/icon/multiUser.png') }}" alt="">
                </div>
                <a class="d-flex text-decoration-none text-light" href="#">Pacientes</a>
            </div>

            <div class="d-flex align-items-center divSubItems">
                <div class="row d-flex subIconsSize">
                    <img src="{{ asset('/img/icon/search.png') }}" alt="">
                </div>
                <a class="d-flex text-decoration-none text-light" href="#">Consultas</a>
            </div>

            <div class="d-flex align-items-center divSubItems">
                <div class="row d-flex subIconsSize">
                    <img src="{{ asset('/img/icon/medicines.png') }}" alt="">
                </div>
                <a class="d-flex text-decoration-none text-light" href="#">Medicamentos</a>
            </div>

            <div class="d-flex align-items-center divSubItems">
                <div class="row d-flex subIconsSize">
                    <img src="{{ asset('/img/icon/heart.png') }}" alt="">
                </div>
                <a class="d-flex text-decoration-none text-light" href="#">Planos</a>
            </div>

            <div class="d-flex align-items-center divSubItems">
                <div class="row d-flex subIconsSize">
                    <img src="{{ asset('/img/icon/trend.png') }}" alt="">
                </div>
                <a class="d-flex text-decoration-none text-light" href="#">Relatórios</a>
            </div>

            <div class="d-flex spacingPowerAdjust">
                <div class="d-flex gap-3 flex-column">
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
        </li>
    </ul>
</div>