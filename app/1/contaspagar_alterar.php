<?php
// Gabriel 22092023 
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "contaspagar_alterar";
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 1) {
            $arquivo = fopen(defineCaminhoLog() . "financeiro_" . date("dmY") . ".log", "a");
        }
    }
}
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL == 1) {
        fwrite($arquivo, $identificacao . "\n");
    }
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-ENTRADA->" . json_encode($jsonEntrada) . "\n");
    }
}
//LOG

$idEmpresa = $jsonEntrada["idEmpresa"];
$conexao = conectaMysql($idEmpresa);
if (isset($jsonEntrada['idCP'])) {
    $idCP = $jsonEntrada['idCP'];
    $idCliente = $jsonEntrada['idCliente'];
    $numeroDocumento = $jsonEntrada['numeroDocumento'];
    $dataEmissao = $jsonEntrada['dataEmissao'];
    $dataVencimento = $jsonEntrada['dataVencimento'];
    $idContaCorrente = isset($jsonEntrada['idContaCorrente']) && $jsonEntrada['idContaCorrente'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['idContaCorrente']) . "'" : "null";
    $dataLiquidacao = $jsonEntrada['dataLiquidacao'];
    $idNotaServico = isset($jsonEntrada['idNotaServico']) && $jsonEntrada['idNotaServico'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['idNotaServico']) . "'" : "null";
    $idCategoria = $jsonEntrada['idCategoria'];
    $valorPagar = $jsonEntrada['valorPagar'];
    $valorAberto = $jsonEntrada['valorAberto'];
    $condicao = $jsonEntrada['condicao'];

    $sql = "UPDATE `contaspagar` SET `idCliente`= $idCliente,`numeroDocumento`= '$numeroDocumento',`dataEmissao`= '$dataEmissao',`dataVencimento`='$dataVencimento',
    `idContaCorrente`= $idContaCorrente,`dataLiquidacao`='$dataLiquidacao',`idNotaServico`= $idNotaServico,`valorPagar`='$valorPagar',`valorAberto`= $valorAberto,`condicao`='$condicao', `idCategoria`='$idCategoria'
    WHERE contaspagar.idCP = $idCP";

    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
        }
    }
    //LOG

    //TRY-CATCH
    try {

        $atualizar = mysqli_query($conexao, $sql);
        if (!$atualizar)
            throw new Exception(mysqli_error($conexao));

        $jsonSaida = array(
            "status" => 200,
            "retorno" => "ok"
        );
    } catch (Exception $e) {
        $jsonSaida = array(
            "status" => 500,
            "retorno" => $e->getMessage()
        );
        if ($LOG_NIVEL >= 1) {
            fwrite($arquivo, $identificacao . "-ERRO->" . $e->getMessage() . "\n");
        }
    } finally {
        // ACAO EM CASO DE ERRO (CATCH), que mesmo assim precise
    }
    //TRY-CATCH
} else {
    $jsonSaida = array(
        "status" => 400,
        "retorno" => "Faltaram parametros"
    );
}

//LOG
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
    }
}
//LOG
