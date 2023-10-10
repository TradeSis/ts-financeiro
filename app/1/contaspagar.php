<?php
// Gabriel 22092023 


//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG 
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
  $LOG_NIVEL = defineNivelLog();
  $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "contaspagar_select";
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
//LOG */


$idEmpresa = null;
if (isset($jsonEntrada["idEmpresa"])) {
  $idEmpresa = $jsonEntrada["idEmpresa"];
}

$conexao = conectaMysql($idEmpresa);
$contas = array();

$sql = "SELECT contaspagar.*, cliente.nomeCliente FROM contaspagar
        LEFT JOIN cliente ON contaspagar.idCliente = cliente.idCliente ";
$where = " where ";

if (isset($jsonEntrada["idCP"])) {
  $sql = $sql . $where . " contaspagar.idCP= " . $jsonEntrada["idCP"];
  $where = " and ";
}
if (isset($jsonEntrada["buscaCP"])) {
  $sql = $sql . $where . " contaspagar.idCP= " . $jsonEntrada["buscaCP"];
  $where = " and ";
}

//echo "-SQL->" . json_encode($sql) . "\n";
$rows = 0;

//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 3) {
    fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
  }
}
//LOG

$rows = 0;
$buscar = mysqli_query($conexao, $sql);
while ($row = mysqli_fetch_array($buscar, MYSQLI_ASSOC)) {
  array_push($contas, $row);
  $rows = $rows + 1;
}

if (isset($jsonEntrada["idCP"]) && $rows == 1) {
  $contas = $contas[0];
}
$jsonSaida = $contas;


//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 2) {
    fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
  }
}
//LOG