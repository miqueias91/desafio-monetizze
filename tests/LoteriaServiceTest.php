<?php

declare(strict_types=1);

require_once 'src/Services/LoteriaService.php';
require_once 'src/Exceptions/LoteriaException.php';
require_once 'src/DTOs/LoteriaDTO.php';

use PHPUnit\Framework\TestCase;

class LoteriaServiceTest extends TestCase
{
    private LoteriaService $loteriaService;

    protected function setUp(): void
    {
        $this->loteriaService = new LoteriaService();
    }

    public function testListarJogoTripulanteSemDados(): void
    {
        $this->expectException(LoteriaException::class);

        // Como nenhum jogo foi gerado ainda, a chamada deve lançar uma exceção
        $this->loteriaService->listarJogoTripulante();
    }

    public function testGerarJogoTripulanteRetornaJogos(): void
    {
        // Mock do DTO com os dados necessários
        $dtoMock = $this->createMock(LoteriaDTO::class);
        $dtoMock->method('getNovoJogo')->willReturn(true);
        $dtoMock->method('getJogos')->willReturn(3);
        $dtoMock->method('getDezenas')->willReturn(6);

        // Executa o método gerarJogoTripulante
        $jogos = $this->loteriaService->gerarJogoTripulante($dtoMock);

        // Verifica se o retorno é um array de jogos
        $this->assertIsArray($jogos);
        $this->assertCount(3, $jogos);

        // Verifica se cada bilhete é uma instância da classe Bilhete
        foreach ($jogos as $jogo) {
            $this->assertInstanceOf(Bilhete::class, $jogo);
            $this->assertCount(6, $jogo->getDezenas()); // Cada jogo deve ter 6 dezenas
        }
    }

    public function testGerarBilhetePremiado(): void
    {
        $bilhetePremiado = $this->loteriaService->gerarBilhetePremiado();
        
        // Verifica se o bilhete premiado é uma instância da classe Bilhete
        $this->assertInstanceOf(Bilhete::class, $bilhetePremiado);
        
        // Verifica se o bilhete premiado tem 6 dezenas
        $this->assertCount(6, $bilhetePremiado->getDezenas());
    }

}
