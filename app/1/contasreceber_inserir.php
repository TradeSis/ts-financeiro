<?php
// Gabriel 22092023
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "contasreceber_inserir";
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

if (isset($jsonEntrada['numeroDocumento'])) {
    $numeroDocumento = $jsonEntrada['numeroDocumento'];
    $idCliente = $jsonEntrada['idCliente'];
    $dataVencimento = $jsonEntrada['dataVencimento'];
    $dataEmissao = $jsonEntrada['dataEmissao'];
    $valorReceber = $jsonEntrada['valorReceber'];
    $valorAberto = $jsonEntrada['valorAberto'];
    $dataLiquidacao = $jsonEntrada['dataLiquidacao'];
    $idNotaServico = $jsonEntrada['idNotaServico'];
    $idCategoria = $jsonEntrada['idCategoria'];
    $condicao = $jsonEntrada['condicao'];
    $idContaCorrente = $jsonEntrada['idContaCorrente'];

    $sql = "INSERT INTO `contasreceber`( `numeroDocumento`, `idCliente`, `dataVencimento`, `dataEmissao`, `valorReceber`, `idContaCorrente`, `valorAberto`, `dataLiquidacao`, `idNotaServico`, 
    `idCategoria`, `condicao`) VALUES ('$numeroDocumento','$idCliente','$dataVencimento','$dataEmissao','$valorReceber','$idContaCorrente','$valorAberto','$dataLiquidacao','$idNotaServico','$idCategoria','$condicao')";

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
    if ($LOG_NIVEL >= 3) {
        fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
    }
}
//LOG 
