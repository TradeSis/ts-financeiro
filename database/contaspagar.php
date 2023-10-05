<?php
// Gabriel 22092023 

include_once __DIR__ . "/../conexao.php";

function buscaCP($idCP = null)
{

	$contas = array();

	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
		$idEmpresa = $_SESSION['idEmpresa'];
	}

	$apiEntrada = array(
		'idEmpresa' => $idEmpresa,
		'idCP' => $idCP
	);
	$contas = chamaAPI(null, '/financeiro/contaspagar', json_encode($apiEntrada), 'GET');

	return $contas;
}


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {

		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'numeroDocumento' => $_POST['numeroDocumento'],
			'idCliente' => $_POST['idCliente'],
			'dataEmissao' => $_POST['dataEmissao'],
			'dataVencimento' => $_POST['dataVencimento'],
			'condicao' => $_POST['condicao'],
			'valorPagar' => $_POST['valorPagar'],
			'valorAberto' => $_POST['valorAberto'],
			'dataLiquidacao' => $_POST['dataLiquidacao'],
			'idNotaServico' => $_POST['idNotaServico'],
			'idCategoria' => $_POST['idCategoria'],
			'idContaCorrente' => $_POST['idContaCorrente']
		);
		$contas = chamaAPI(null, '/financeiro/contaspagar', json_encode($apiEntrada), 'PUT');


		/* header('Location: ../contass/visualizar.php?idCP=' . $apiEntrada['idCP']); */
	}

	if ($operacao == "alterar") {
		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idCP' => $_POST['idCP'],
			'numeroDocumento' => $_POST['numeroDocumento'],
			'idCliente' => $_POST['idCliente'],
			'dataEmissao' => $_POST['dataEmissao'],
			'dataVencimento' => $_POST['dataVencimento'],
			'condicao' => $_POST['condicao'],
			'valorPagar' => $_POST['valorPagar'],
			'valorAberto' => $_POST['valorAberto'],
			'dataLiquidacao' => $_POST['dataLiquidacao'],
			'idNotaServico' => $_POST['idNotaServico'],
			'idCategoria' => $_POST['idCategoria'],
			'idContaCorrente' => $_POST['idContaCorrente']
		);
		$contas = chamaAPI(null, '/financeiro/contaspagar', json_encode($apiEntrada), 'POST');
		//header('Location: ../contass/visualizar.php?idCP=' . $apiEntrada['idCP']);
	}

	if ($operacao == "filtrar") {

		$buscaCP = $_POST['buscaCP'];

		if ($buscaCP == "") {
			$buscaCP = null;
		}

		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'buscaCP' => $buscaCP
		);
		$contas = chamaAPI(null, '/financeiro/contaspagar', json_encode($apiEntrada), 'GET');

		echo json_encode($contas);
		return $contas;
	}

	if ($operacao == "buscar") {
		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idCP' => $_POST['idCP']
		);
		$contas = chamaAPI(null, '/financeiro/contaspagar', json_encode($apiEntrada), 'GET');

		echo json_encode($contas);
		return $contas;
	}

}