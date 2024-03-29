<?php
// lucas 11102023 novo padrao
// Gabriel 22092023 

include_once(__DIR__ . '/../header.php');
include_once(__DIR__ . '/../database/contasreceber.php');
include_once(ROOT . '/cadastros/database/clientes.php');

$clientes = buscaClientes();
?>

<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>



<body>
    <div class="container-fluid">

        <div class="row">
            <!-- MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <!-- BOTOES AUXILIARES -->
        </div>
        <div class="row d-flex align-items-center justify-content-center mt-1 pt-1 ">

            <div class="col-2 col-lg-1 order-lg-1">
                <button class="btn btn-outline-secondary ts-btnFiltros" type="button"><i class="bi bi-funnel"></i></button>
            </div>

            <div class="col-4 col-lg-3 order-lg-2">

                <h2 class="ts-tituloPrincipal">Contas à receber</h2>
                <span>Filtro Aplicado</span>

            </div>
            <div class="col-6 col-lg-2 order-lg-3">
                <!-- FILTROS -->
            </div>
            <div class="col-12 col-lg-6 order-lg-4">
                <div class="input-group">
                    <input type="text" class="form-control ts-input" id="buscaCR" placeholder="Buscar por idCR">
                    <button class="btn btn-primary rounded" type="button" id="buscar"><i class="bi bi-search"></i></button>
                    <button type="button" class="ms-4 btn btn-success" data-bs-toggle="modal" data-bs-target="#inserirModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
                </div>
            </div>

        </div>

        <div class="ts-menuFiltros mt-2 px-3">
            <label>Filtrar por:</label>

            <!-- Gabriel 06102023 ID 596 ajustado posiçao -->
            <div class="col-12"> <!-- ABERTO/FECHADO -->
                <form class="d-flex" action="" method="post">
                    <select class="form-select" name="idCliente" id="FiltroClientes">
                        <option value="<?php echo null ?>">
                            <?php echo "Cliente" ?>
                        </option>
                        <?php
                        foreach ($clientes as $cliente) {
                        ?>
                            <option <?php
                                    ?> value="<?php echo $cliente['idCliente'] ?>">
                                <?php echo $cliente['nomeCliente'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </form>
            </div>

            <div class="col-sm text-end mt-2">
                <a onClick="limpar()" role=" button" class="btn btn-sm bg-info text-white">Limpar</a>
            </div>
        </div>

        <div class="table mt-2 ts-divTabela ts-tableFiltros text-center">
            <table class="table table-sm table-hover">
                <thead class="ts-headertabelafixo">
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>idNota</th>
                        <th>Emissão</th>
                        <th>Condição</th>
                        <th>Documento</th>
                        <th>vlReceber</th>
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



        <!--------- INSERIR --------->
        <div class="modal" id="inserirModal" tabindex="-1" aria-labelledby="inserirModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Inserir CR</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="inserirFormCR">
                            <div class="row">
                                <div class="col-md">
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label class="form-label ts-label">numeroDocumento</label>
                                            <input type="text" class="form-control ts-input" name="numeroDocumento" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label ts-label">Cliente</label>
                                            <input type="hidden" class="form-control ts-input" name="idCliente" value="<?php echo $usuario['idUsuario'] ?>" readonly>
                                            <select class="form-select ts-input" name="idCliente" autocomplete="off" required>
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
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">dataEmissao</label>
                                            <input type="date" class="form-control ts-input" name="dataEmissao" required>
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">dataVencimento</label>
                                            <input type="date" class="form-control ts-input" name="dataVencimento">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">condicao</label>
                                            <select class="form-select ts-input" id="condicao" name="condicao">
                                                <option value="<?php echo null ?>">
                                                    <?php echo "Nenhuma" ?>
                                                </option>
                                                <option value="dias">dias</option>
                                                <option value="Perc">Perc</option>
                                            </select>
                                        </div>
                                    </div><!--fim row 2-->
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">valorReceber</label>
                                            <input type="number" class="form-control ts-input" name="valorReceber" required>
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">valorAberto</label>
                                            <input type="number" class="form-control ts-input" name="valorAberto">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">dataLiquidacao</label>
                                            <input type="date" class="form-control ts-input" name="dataLiquidacao">
                                        </div>
                                    </div><!--fim row 3-->
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">idNotaServico</label>
                                            <input type="number" class="form-control ts-input" name="idNotaServico">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">idCategoria</label>
                                            <input type="number" class="form-control ts-input" name="idCategoria" required>
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">idContaCorrente</label>
                                            <input type="number" class="form-control ts-input" name="idContaCorrente">
                                        </div>
                                    </div><!--fim row 4-->
                                </div>
                            </div>
                    </div><!--body-->
                    <div class="modal-footer">
                        <div class="card-footer bg-transparent text-end">
                            <button type="submit" class="btn btn-success">Cadastrar</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!--------- ALTERAR --------->
        <div class="modal" id="alterarmodal" tabindex="-1" aria-labelledby="alterarmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alterar CR</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="alterarFormCR">
                            <div class="row">
                                <div class="col-md">
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label class="form-label ts-label">numeroDocumento</label>
                                            <input type="text" class="form-control ts-input" id="numeroDocumento" name="numeroDocumento" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label ts-label">Cliente</label>
                                            <input type="text" class="form-control ts-input" name="nomeCliente" id="nomeCliente" disabled>
                                            <input type="hidden" class="form-control ts-input" name="idCliente" id="idCliente">
                                            <input type="hidden" class="form-control ts-input" name="idCR" id="idCR">
                                        </div>
                                    </div><!--fim row 1-->
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">dataEmissao</label>
                                            <input type="date" class="form-control ts-input" id="dataEmissao" name="dataEmissao" required>
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">dataVencimento</label>
                                            <input type="date" class="form-control ts-input" id="dataVencimento" name="dataVencimento">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">condicao</label>
                                            <select class="form-select ts-input" id="condicao" name="condicao">
                                                <option value="<?php echo null ?>">
                                                    <?php echo "Nenhuma" ?>
                                                </option>
                                                <option value="dias">dias</option>
                                                <option value="Perc">Perc</option>
                                            </select>
                                        </div>
                                    </div><!--fim row 2-->
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">valorReceber</label>
                                            <input type="number" class="form-control ts-input" id="valorReceber" name="valorReceber" required>
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">valorAberto</label>
                                            <input type="number" class="form-control ts-input" id="valorAberto" name="valorAberto">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">dataLiquidacao</label>
                                            <input type="date" class="form-control ts-input" id="dataLiquidacao" name="dataLiquidacao">
                                        </div>
                                    </div><!--fim row 3-->
                                    <div class="row mt-3">
                                        <div class="col-md">
                                            <label class="form-label ts-label">idNotaServico</label>
                                            <input type="number" class="form-control ts-input" id="idNotaServico" name="idNotaServico">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">idCategoria</label>
                                            <input type="number" class="form-control ts-input" id="idCategoria" name="idCategoria" required>
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label ts-label">idContaCorrente</label>
                                            <input type="number" class="form-control ts-input" id="idContaCorrente" name="idContaCorrente">
                                        </div>
                                    </div><!--fim row 4-->
                                </div>
                            </div>
                    </div><!--body-->
                    <div class="modal-footer">
                        <div class="card-footer bg-transparent text-end">
                            <button type="submit" class="btn btn-success">Salvar</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- LOCAL PARA COLOCAR OS JS -->

        <?php include_once ROOT . "/vendor/footer_js.php"; ?>

        <!-- script para menu de filtros -->
        <script src="<?php echo URLROOT ?>/sistema/js/filtroTabela.js"></script>
        <script>
            buscar($("#buscaCR").val());

            function buscar(buscaCR) {
                $.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: '<?php echo URLROOT ?>/financeiro/database/contasreceber.php?operacao=filtrar',
                    beforeSend: function() {
                        $("#dados").html("Carregando...");
                    },
                    data: {
                        buscaCR: buscaCR
                    },
                    success: function(msg) {
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
                            linha += "<td>" + object.idCR + "</td>";
                            linha += "<td>" + object.nomeCliente + "</td>";
                            linha += "<td>" + object.idNotaServico + "</td>";
                            linha += "<td>" + dataEmissaoFormatada + "</td>";
                            linha += "<td>" + object.condicao + "</td>";
                            linha += "<td>" + object.numeroDocumento + "</td>";
                            linha += "<td>" + object.valorReceber + "</td>";
                            linha += "<td>" + object.valorAberto + "</td>";
                            linha += "<td>" + dataVencimentoFormatada + "</td>";
                            linha += "<td>" + dataLiquidacaoFormatada + "</td>";
                            linha += "<td>" + object.idCategoria + "</td>";
                            linha += "<td>" + object.idContaCorrente + "</td>";
                            linha += "<td>" + "<button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#alterarmodal' data-idCR='" + object.idCR + "'><i class='bi bi-pencil-square'></i></button>"
                            linha += "</tr>";
                        }

                        $("#dados").html(linha);

                    }
                });
            }

            $("#buscaCR").change(function() {
                buscar($("#buscaCR").val());
            });
            document.addEventListener("keypress", function(e) {
                if (e.key === "Enter") {
                    buscar();
                }
            });

            $(document).on('click', 'button[data-target="#alterarmodal"]', function() {
                var idCR = $(this).attr("data-idCR");
                //alert(idCR)
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '<?php echo URLROOT ?>/financeiro/database/contasreceber.php?operacao=buscar',
                    data: {
                        idCR: idCR
                    },
                    success: function(data) {
                        $('#idCR').val(data.idCR);
                        $('#numeroDocumento').val(data.numeroDocumento);
                        $('#idCliente').val(data.idCliente);
                        $('#nomeCliente').val(data.nomeCliente);
                        $('#dataEmissao').val(data.dataEmissao);
                        $('#dataVencimento').val(data.dataVencimento);
                        $('#condicao').val(data.condicao);
                        $('#valorReceber').val(data.valorReceber);
                        $('#valorAberto').val(data.valorAberto);
                        $('#dataLiquidacao').val(data.dataLiquidacao);
                        $('#idNotaServico').val(data.idNotaServico);
                        $('#idCategoria').val(data.idCategoria);
                        $('#idContaCorrente').val(data.idContaCorrente);
                        $('#alterarmodal').modal('show');
                    }
                });
            });



            var inserirModal = document.getElementById("inserirModal");

            var inserirBtn = document.querySelector("button[data-target='#inserirModal']");

            inserirBtn.onclick = function() {
                inserirModal.style.display = "block";
            };

            window.onclick = function(event) {
                if (event.target == inserirModal) {
                    inserirModal.style.display = "none";
                }
            };
        </script>

        <script>
            $(document).ready(function() {
                $("#inserirFormCR").submit(function(event) {
                    event.preventDefault();
                    var formData = new FormData(this);
                    $.ajax({
                        url: "../database/contasreceber.php?operacao=inserir",
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: refreshPage,
                    });
                });

                $("#alterarFormCR").submit(function(event) {
                    event.preventDefault();
                    var formData = new FormData(this);
                    $.ajax({
                        url: "../database/contasreceber.php?operacao=alterar",
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

        <!-- LOCAL PARA COLOCAR OS JS -FIM -->


</body>

</html>