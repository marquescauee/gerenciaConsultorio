<style>
    .mainDiv {
        width: 15%;
        position: absolute;
        top: 0;
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
</style>


@section('content')
    <div style="background-color: #66737e;" class="d-flex mainDiv h-100">
        <ul class="d-flex mt-4">
            <li class="d-flex flex-column gap-3">

                <div class="d-flex align-items-center gap-4">
                    <div class="row d-flex iconSize">
                        <x-fluentui-dentist-20 />
                    </div>
                    <a class="d-flex text-decoration-none text-light" href="#">Gerência Consultório</a>
                </div>


                <div class="d-flex align-items-center gap-4 mt-3">
                    <div class="row d-flex iconSize">
                        <x-zondicon-user-solid-circle />
                    </div>
                    <a class="d-flex text-decoration-none text-light" href="#">Administrador</a>
                </div>

                <div class="d-flex align-items-center divSubItems mt-3">
                    <div class="row d-flex subIconsSize">
                        <x-phosphor-medal-fill />
                    </div>
                    <a class="d-flex text-decoration-none text-light" href="#">Fornecedores</a>
                </div>

                <div class="d-flex align-items-center divSubItems">
                    <div class="row d-flex subIconsSize">
                        <x-govicon-user-suit />
                    </div>
                    <a class="d-flex text-decoration-none text-light" href="#">Doutores</a>
                </div>

                <div class="d-flex align-items-center divSubItems">
                    <div class="row d-flex subIconsSize">
                        <x-heroicon-s-user-group />
                    </div>
                    <a class="d-flex text-decoration-none text-light" href="#">Clientes</a>
                </div>

                <div class="d-flex align-items-center divSubItems">
                    <div class="row d-flex subIconsSize">
                        <x-tabler-file-search />
                    </div>
                    <a class="d-flex text-decoration-none text-light" href="#">Consultas</a>
                </div>

                <div class="d-flex align-items-center divSubItems">
                    <div class="row d-flex subIconsSize">
                        <x-ri-medicine-bottle-fill />
                    </div>
                    <a class="d-flex text-decoration-none text-light" href="#">Medicamentos</a>
                </div>

                <div class="d-flex align-items-center divSubItems">
                    <div class="row d-flex subIconsSize">
                        <x-ri-heart-add-fill />
                    </div>
                    <a class="d-flex text-decoration-none text-light" href="#">Planos</a>
                </div>

                <div class="d-flex align-items-center divSubItems">
                    <div class="row d-flex subIconsSize">
                        <x-codicon-graph-line />
                    </div>
                    <a class="d-flex text-decoration-none text-light" href="#">Relatórios</a>
                </div>

                <div class="d-flex spacingPowerAdjust">
                    <div class="d-flex gap-3 flex-column">
                        <div class="d-flex align-items-center divSubItems">
                            <div class="row d-flex subIconsSize">
                                <x-eos-settings />
                            </div>
                            <a class="d-flex text-decoration-none text-light" href="#">Ajustes</a>
                        </div>
                        <div class="d-flex align-items-center divSubItems">
                            <div class="row d-flex subIconsSize">
                                <x-jam-power />
                            </div>
                            <a class="d-flex text-decoration-none text-light" href="#">Sair</a>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
@endsection
