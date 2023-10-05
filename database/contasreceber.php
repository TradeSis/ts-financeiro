<?php
// Gabriel 22092023 

include_once __DIR__ . "/../conexao.php";

function buscaCR($idCR = null)
{

	$contas = array();

	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
		$idEmpresa = $_SESSION['idEmpresa'];
	}

	$apiEntrada = array(
		'idEmpresa' => $idEmpresa,
		'idCR' => $idCR
	);
	$contas = chamaAPI(null, '/financeiro/contasreceber', json_encode($apiEntrada), 'GET');

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
			'valorReceber' => $_POST['valorReceber'],
			'valorAberto' => $_POST['valorAberto'],
			'dataLiquidacao' => $_POST['dataLiquidacao'],
			'idNotaServico' => $_POST['idNotaServico'],
			'idCategoria' => $_POST['idCategoria'],
			'idContaCorrente' => $_POST['idContaCorrente']
		);
		$contas = chamaAPI(null, '/financeiro/contasreceber', json_encode($apiEntrada), 'PUT');


		/* header('Location: ../contass/visualizar.php?idCR=' . $apiEntrada['idCR']); */
	}

	if ($operacao == "alterar") {
		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idCR' => $_POST['idCR'],
			'numeroDocumento' => $_POST['numeroDocumento'],
			'idCliente' => $_POST['idCliente'],
			'dataEmissao' => $_POST['dataEmissao'],
			'dataVencimento' => $_POST['dataVencimento'],
			'condicao' => $_POST['condicao'],
			'valorReceber' => $_POST['valorReceber'],
			'valorAberto' => $_POST['valorAberto'],
			'dataLiquidacao' => $_POST['dataLiquidacao'],
			'idNotaServico' => $_POST['idNotaServico'],
			'idCategoria' => $_POST['idCategoria'],
			'idContaCorrente' => $_POST['idContaCorrente']
		);
		$contas = chamaAPI(null, '/financeiro/contasreceber', json_encode($apiEntrada), 'POST');
		//header('Location: ../contass/visualizar.php?idCR=' . $apiEntrada['idCR']);
	}

	if ($operacao == "filtrar") {

		$buscaCR = $_POST['buscaCR'];

		if ($buscaCR == "") {
			$buscaCR = null;
		}

		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'buscaCR' => $buscaCR
		);
		$contas = chamaAPI(null, '/financeiro/contasreceber', json_encode($apiEntrada), 'GET');

		echo json_encode($contas);
		return $contas;
	}

	if ($operacao == "buscar") {
		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idCR' => $_POST['idCR']
		);
		$contas = chamaAPI(null, '/financeiro/contasreceber', json_encode($apiEntrada), 'GET');

		echo json_encode($contas);
		return $contas;
	}

}