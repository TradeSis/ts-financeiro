<?php

//echo "metodo=".$metodo."\n";
//echo "funcao=".$funcao."\n";
//echo "parametro=".$parametro."\n";

if ($metodo == "GET") {

  switch ($funcao) {

    case "contasreceber":
      include 'contasreceber.php';
      break;

    case "contaspagar":
      include 'contaspagar.php';
      break;

   

    default:
      $jsonSaida = json_decode(json_encode(
        array(
          "status" => "400",
          "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
        )
      ), TRUE);
      break;
  }
}

if ($metodo == "PUT") {
  switch ($funcao) {

    case "contasreceber":
      include 'contasreceber_inserir.php';
      break;

    case "contaspagar":
      include 'contaspagar_inserir.php';
      break;

    default:
      $jsonSaida = json_decode(json_encode(
        array(
          "status" => "400",
          "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
        )
      ), TRUE);
      break;
  }
}

if ($metodo == "POST") {

  switch ($funcao) {

    case "contasreceber":
      include 'contasreceber_alterar.php';
      break;

    case "contaspagar":
      include 'contaspagar_alterar.php';
      break;

    default:
      $jsonSaida = json_decode(json_encode(
        array(
          "status" => "400",
          "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
        )
      ), TRUE);
      break;
  }
}

if ($metodo == "DELETE") {
  switch ($funcao) {
    
  
    default:
      $jsonSaida = json_decode(json_encode(
        array(
          "status" => "400",
          "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
        )
      ), TRUE);
      break;
  }
}
