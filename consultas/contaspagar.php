<?php
// Gabriel 22092023 

include_once(__DIR__ . '/../head.php');
include_once(__DIR__ . '/../database/contaspagar.php');
include_once(ROOT . '/cadastros/database/clientes.php');

$clientes = buscaClientes();
?>

</html>

<body class="bg-transparent">

    <nav id="menuFiltros" class="menuFiltros"> <!-- MENUFILTROS -->
        <div class="titulo"><span>Filtrar por:</span></div>
        <ul>
            <li class="col-sm-12">
                <form class="d-flex" action="" method="post" style="text-align: right;">
                    <select class="form-control" name="idCliente" id="FiltroClientes"
                        style="font-size: 14px; width: 150px; height: 35px">
                        <option value="<?php echo null ?>">
                            <?php echo "Cliente" ?>
                        </option>
                        <?php
                        foreach ($clientes as $cliente) {
                            ?>
                            <option <?php
                            /*  if ($cliente['idCliente'] == $idCliente) {
                                echo "selected";
                            } */
                            ?> value="<?php echo $cliente['idCliente'] ?>">
                                <?php echo $cliente['nomeCliente'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </form>
            </li>
        </ul>

        <div class="col-sm" style="text-align:right; color: #fff">
            <a onClick="limpar()" role=" button" class="btn btn-sm" style="background-color:#84bfc3; ">Limpar</a>
        </div>
    </nav>


    <div class="container-fluid text-center mt-4">
        <div class="row">
            <div class=" btnAbre">
                <span style="font-size: 25px; font-family: 'Material Symbols Outlined'!important;"
                    class="material-symbols-outlined">
                    filter_alt
                </span>
            </div>

            <div class="col-sm-3 ml-2">
                <h2 class="tituloTabela">
                    Contas à Pagar
                </h2>
            </div>

            <div class="col-sm-4" style="margin-top:-10px;">
                <div class="input-group">
                    <input type="text" class="form-control" id="buscaCP" placeholder="Buscar por idCP">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" id="buscar" type="button" style="margin-top:10px;">
                            <span style="font-size: 20px;font-family: 'Material Symbols Outlined'!important;"
                                class="material-symbols-outlined">search</span>
                        </button>
                    </span>
                </div>
            </div>

            <div class="col-sm" style="text-align:right">
                <button type="button" class="btn btn-success mr-4" data-toggle="modal" data-target="#inserirModal"><i
                        class="bi bi-plus-square"></i>&nbsp Novo</button>
            </div>
        </div>

        <div class="card mt-2 text-center">
            <div class="table table-sm table-hover table-striped table-wrapper-scroll-y my-custom-scrollbar diviFrame">
                <table class="table">
                    <thead class="cabecalhoTabela">
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>idNota</th>
                            <th>Emissão</th>
                            <th>Condição</th>
                            <th>Documento</th>
                            <th>vlPagar</th>
                            <th>vlAberto</th>
                            <th>Vencimento</th>
                            <th>Liquidado</th>
                            <th>Categoria</th>
                            <th>CC</th>
                            <th>Ação</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody id='dados' class="fonteCorpo">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!--------- INSERIR --------->
    <div class="modal fade bd-example-modal-lg" id="inserirModal" tabindex="-1" role="dialog"
        aria-labelledby="inserirModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Inserir CP</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container-fluid">
                    <form method="post" id="inserirFormCP">
                        <div class="row" style="margin-top: 5px;">
                            <div class="col-md" style="margin-top: 25px;">
                                <div class="row">
                                    <div class="col-md-6 form-group" style="margin-top: -20px;">
                                        <label class="labelForm">numeroDocumento</label>
                                        <input type="text" class="data select form-control" name="numeroDocumento"
                                            required>
                                    </div>
                                    <div class="col-md-6 form-group-select" style="margin-top: -20px;">
                                        <label class="labelForm">Cliente</label>
                                        <input type="hidden" class="form-control" name="idCliente"
                                            value="<?php echo $usuario['idUsuario'] ?>" readonly>
                                        <select class="select form-control" name="idCliente" autocomplete="off"
                                            style="margin-top: -10px;" required>
                                            <?php
                                            foreach ($clientes as $cliente) {
                                                ?>
                                            <option value="<?php echo $cliente['idCliente'] ?>">
                                                <?php echo $cliente['nomeCliente'] ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div><!--fim row 1-->
                                <div class="row">
                                    <div class="col-md form-group" style="margin-top: -40px;">
                                        <label class="labelForm">dataEmissao</label>
                                        <input type="date" class="data select form-control" name="dataEmissao" required>
                                    </div>
                                    <div class="col-md form-group" style="margin-top: -40px;">
                                        <label class="labelForm">dataVencimento</label>
                                        <input type="date" class="data select form-control" name="dataVencimento">
                                    </div>
                                    <div class="col-md form-group" style="margin-top: -40px; ">
                                        <label class="labelForm">condicao</label>
                                        <select class="select form-control" name="condicao">
                                            <option value="<?php echo null ?>">
                                                <?php echo "Nenhuma" ?>
                                            </option>
                                            <option value="dias">dias</option>
                                            <option value="Perc">Perc</option>
                                        </select>
                                    </div>
                                </div><!--fim row 2-->
                                <div class="row">
                                    <div class="col-md form-group" style="margin-top: -40px;">
                                        <label class="labelForm">valorPagar</label>
                                        <input type="number" class="data select form-control" name="valorPagar"
                                            required>
                                    </div>
                                    <div class="col-md form-group" style="margin-top: -40px;">
                                        <label class="labelForm">valorAberto</label>
                                        <input type="number" class="data select form-control" name="valorAberto">
                                    </div>
                                    <div class="col-md form-group" style="margin-top: -40px;">
                                        <label class="labelForm">dataLiquidacao</label>
                                        <input type="date" class="data select form-control" name="dataLiquidacao">
                                    </div>
                                </div><!--fim row 3-->
                                <div class="row">
                                    <div class="col-md form-group" style="margin-top: -40px;">
                                        <label class="labelForm">idNotaServico</label>
                                        <input type="number" class="data select form-control" name="idNotaServico">
                                    </div>
                                    <div class="col-md form-group" style="margin-top: -40px;">
                                        <label class="labelForm">idCategoria</label>
                                        <input type="number" class="data select form-control" name="idCategoria"
                                            required>
                                    </div>
                                    <div class="col-md form-group" style="margin-top: -40px;">
                                        <label class="labelForm">idContaCorrente</label>
                                        <input type="number" class="data select form-control" name="idContaCorrente">
                                    </div>
                                </div><!--fim row 4-->
                            </div>
                        </div>
                        <div class="card-footer bg-transparent" style="text-align:right">
                            <button type="submit" class="btn btn-success">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--------- ALTERAR --------->
    <div class="modal fade bd-example-modal-lg" id="alterarmodal" tabindex="-1" role="dialog"
        aria-labelledby="alterarmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Alterar CP</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container">
                    <form method="post" id="alterarFormCP">
                        <div class="row" style="margin-top: 5px;">
                            <div class="col-md" style="margin-top: 25px;">
                                <div class="row">
                                    <div class="col-md-6 form-group" style="margin-top: -20px;">
                                        <label class="labelForm">numeroDocumento</label>
                                        <input type="text" class="data select form-control" id="numeroDocumento"
                                            name="numeroDocumento" required>
                                    </div>
                                    <div class="col-md-6 form-group-select" style="margin-top: -20px;">
                                        <label class="labelForm">Cliente</label>
                                        <input type="text" class="data select form-control" name="nomeCliente"
                                            id="nomeCliente" disabled>
                                        <input type="text" class="data select form-control" name="idCliente"
                                            id="idCliente" style="display: none;">
                                        <input type="text" class="data select form-control" name="idCP" id="idCP"
                                            style="display: none;">
                                    </div>
                                </div><!--fim row 1-->
                                <div class="row">
                                    <div class="col-md form-group" style="margin-top: -40px;">
                                        <label class="labelForm">dataEmissao</label>
                                        <input type="date" class="data select form-control" id="dataEmissao"
                                            name="dataEmissao" required>
                                    </div>
                                    <div class="col-md form-group" style="margin-top: -40px;">
                                        <label class="labelForm">dataVencimento</label>
                                        <input type="date" class="data select form-control" id="dataVencimento"
                                            name="dataVencimento">
                                    </div>
                                    <div class="col-md form-group" style="margin-top: -40px; ">
                                        <label class="labelForm">condicao</label>
                                        <select class="select form-control" id="condicao" name="condicao">
                                            <option value="<?php echo null ?>">
                                                <?php echo "Nenhuma" ?>
                                            </option>
                                            <option value="dias">dias</option>
                                            <option value="Perc">Perc</option>
                                        </select>
                                    </div>
                                </div><!--fim row 2-->
                                <div class="row">
                                    <div class="col-md form-group" style="margin-top: -40px;">
                                        <label class="labelForm">valorPagar</label>
                                        <input type="number" class="data select form-control" id="valorPagar"
                                            name="valorPagar" required>
                                    </div>
                                    <div class="col-md form-group" style="margin-top: -40px;">
                                        <label class="labelForm">valorAberto</label>
                                        <input type="number" class="data select form-control" id="valorAberto"
                                            name="valorAberto">
                                    </div>
                                    <div class="col-md form-group" style="margin-top: -40px;">
                                        <label class="labelForm">dataLiquidacao</label>
                                        <input type="date" class="data select form-control" id="dataLiquidacao"
                                            name="dataLiquidacao">
                                    </div>
                                </div><!--fim row 3-->
                                <div class="row">
                                    <div class="col-md form-group" style="margin-top: -40px;">
                                        <label class="labelForm">idNotaServico</label>
                                        <input type="number" class="data select form-control" id="idNotaServico"
                                            name="idNotaServico">
                                    </div>
                                    <div class="col-md form-group" style="margin-top: -40px;">
                                        <label class="labelForm">idCategoria</label>
                                        <input type="number" class="data select form-control" id="idCategoria"
                                            name="idCategoria" required>
                                    </div>
                                    <div class="col-md form-group" style="margin-top: -40px;">
                                        <label class="labelForm">idContaCorrente</label>
                                        <input type="number" class="data select form-control" id="idContaCorrente"
                                            name="idContaCorrente">
                                    </div>
                                </div><!--fim row 4-->
                            </div>
                        </div>
                        <div class="card-footer bg-transparent" style="text-align:right">
                            <button type="submit" class="btn btn-success">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        buscar($("#buscaCP").val());

        function buscar(buscaCP) {
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '<?php echo URLROOT ?>/financeiro/database/contaspagar.php?operacao=filtrar',
                beforeSend: function () {
                    $("#dados").html("Carregando...");
                },
                data: {
                    buscaCP: buscaCP
                },
                success: function (msg) {
                    var json = JSON.parse(msg);
                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];

                        function formatDate(dateString) {
                            if (dateString !== null && !isNaN(new Date(dateString))) {
                                var date = new Date(dateString);
                                var day = date.getUTCDate().toString().padStart(2, '0');
                                var month = (date.getUTCMonth() + 1).toString().padStart(2, '0');
                                var year = date.getUTCFullYear().toString().padStart(4, '0');
                                return day + "/" + month + "/" + year;
                            }
                            return "00/00/0000";
                        }

                        var dataEmissaoFormatada = formatDate(object.dataEmissao);
                        var dataVencimentoFormatada = formatDate(object.dataVencimento);
                        var dataLiquidacaoFormatada = formatDate(object.dataLiquidacao);

                        linha += "<tr>";
                        linha += "<td>" + object.idCP + "</td>";
                        linha += "<td>" + object.nomeCliente + "</td>";
                        linha += "<td>" + object.idNotaServico + "</td>";
                        linha += "<td>" + dataEmissaoFormatada + "</td>";
                        linha += "<td>" + object.condicao + "</td>";
                        linha += "<td>" + object.numeroDocumento + "</td>";
                        linha += "<td>" + object.valorPagar + "</td>";
                        linha += "<td>" + object.valorAberto + "</td>";
                        linha += "<td>" + dataVencimentoFormatada + "</td>";
                        linha += "<td>" + dataLiquidacaoFormatada + "</td>";
                        linha += "<td>" + object.idCategoria + "</td>";
                        linha += "<td>" + object.idContaCorrente + "</td>";
                        linha += "<td>" + "<button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#alterarmodal' data-idCP='" + object.idCP + "'><i class='bi bi-pencil-square'></i></button>"
                        linha += "</tr>";
                    }

                    $("#dados").html(linha);

                }
            });
        }

        $("#buscaCP").click(function () {
            buscar($("#buscaCP").val());
        });
        document.addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
                buscar();
            }
        });

        $(document).on('click', 'button[data-target="#alterarmodal"]', function () {
            var idCP = $(this).attr("data-idCP");
            //alert(idCP)
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/financeiro/database/contaspagar.php?operacao=buscar',
                data: {
                    idCP: idCP
                },
                success: function (data) {
                    $('#idCP').val(data.idCP);
                    $('#numeroDocumento').val(data.numeroDocumento);
                    $('#idCliente').val(data.idCliente);
                    $('#nomeCliente').val(data.nomeCliente);
                    $('#dataEmissao').val(data.dataEmissao);
                    $('#dataVencimento').val(data.dataVencimento);
                    $('#condicao').val(data.condicao);
                    $('#valorPagar').val(data.valorPagar);
                    $('#valorAberto').val(data.valorAberto);
                    $('#dataLiquidacao').val(data.dataLiquidacao);
                    $('#idNotaServico').val(data.idNotaServico);
                    $('#idCategoria').val(data.idCategoria);
                    $('#idContaCorrente').val(data.idContaCorrente);
                    $('#alterarmodal').modal('show');
                }
            });
        });


        $('.btnAbre').click(function () {
            $('.menuFiltros').toggleClass('mostra');
            $('.diviFrame').toggleClass('mostra');
        });

        var inserirModal = document.getElementById("inserirModal");

        var inserirBtn = document.querySelector("button[data-target='#inserirModal']");

        inserirBtn.onclick = function () {
            inserirModal.style.display = "block";
        };

        window.onclick = function (event) {
            if (event.target == inserirModal) {
                inserirModal.style.display = "none";
            }
        };
    </script>

    <script>
        $(document).ready(function() {
            $("#inserirFormCP").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/contaspagar.php?operacao=inserir",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });

          $("#alterarFormCP").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/contaspagar.php?operacao=alterar",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            }); 

            function refreshPage() {
                window.location.reload();
            }
        });
    </script>




</body>

</html>