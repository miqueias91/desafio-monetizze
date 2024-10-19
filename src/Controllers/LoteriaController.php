<?php

declare(strict_types=1);

require_once 'src/DTOs/LoteriaDTO.php';
require_once 'src/Exceptions/LoteriaException.php';
require_once 'src/Services/LoteriaService.php';
require_once 'src/Responses/Response.php';

class LoteriaController
{
    private LoteriaService $loteriaService;

    public function __construct()
    {
        $this->loteriaService = new LoteriaService();
    }

    public function gerarJogoTripulante(array $dados): JsonSerializable
    {
        try {
            $dto = new LoteriaDTO($dados);
            return Response::json($this->loteriaService->gerarJogoTripulante($dto), 201);
        } catch (LoteriaException $e) {
            return Response::json(['erro' => [$e->getField() => $e->getMessage()]], $e->getCode());
        }
    }

    public function listarJogoTripulante(): JsonSerializable
    {

        try {
            return Response::json($this->loteriaService->listarJogoTripulante(), 200);
        } catch (LoteriaException $e) {
            return Response::json(['erro' => [$e->getField() => $e->getMessage()]], $e->getCode());
        }
    }

    public function gerarTabelaResultadoLoteria(): string
    {

        try {
            return $this->loteriaService->gerarTabelaResultadoLoteria();
        } catch (LoteriaException $e) {
            return Response::json(['erro' => [$e->getField() => $e->getMessage()]], $e->getCode());
        }
    }
}
