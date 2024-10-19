<?php

declare(strict_types=1);

require_once 'src/Controllers/LoteriaController.php';

$loteriaController = new LoteriaController();

//gerar bilhetes para o tripulante.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/loteria/solicitar') {
    $dados = json_decode(file_get_contents('php://input'), true);
    echo $loteriaController->gerarJogoTripulante($dados);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/loteria/listar') {
    echo $loteriaController->listarJogoTripulante();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/loteria/resultado') {
    $dados = json_decode(file_get_contents('php://input'), true);
    echo $loteriaController->gerarTabelaResultadoLoteria($dados);
}