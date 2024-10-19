<?php

declare(strict_types=1);

require_once 'src/DTOs/LoteriaDTO.php';
require_once 'src/Models/Bilhete.php';
require_once 'src/Models/Cache.php';

class LoteriaService
{
    private Cache $cache;
    private const CACHE_KEY_JOGOS = 'jogos-tripulante';
    private const CACHE_KEY_PREMIADO = 'bilhete-premiado';

    public function __construct() {
        $this->cache = new Cache(1800); // 30 minutos de cache
    }

    public function gerarJogoTripulante(LoteriaDTO $dto): array
    {
        if ($dto->getNovoJogo()) {
            $this->cache->forget(self::CACHE_KEY_JOGOS);
            $this->cache->forget(self::CACHE_KEY_PREMIADO);
        }

        return $this->cache->remember(self::CACHE_KEY_JOGOS, function() use ($dto) {
            $bilhetes = [];
            for ($i = 0; $i < $dto->getJogos(); $i++) {
                $bilhetes[] = new Bilhete($this->gerarDezenasUnicas($dto->getDezenas()));
            }
            return $bilhetes;
        });
    }

    public function listarJogoTripulante(): array
    {
        $bilhetesTripulante = $this->cache->get(self::CACHE_KEY_JOGOS);
        if (!$bilhetesTripulante) {
            throw new LoteriaException('Nenhum bilhete de tripulante encontrado.', 'bilhetesTripulante', 404);
        }
        return $bilhetesTripulante;
    }

    public function gerarBilhetePremiado(): Bilhete
    {
        return $this->cache->remember(self::CACHE_KEY_PREMIADO, function() {
            $dezenas = $this->gerarDezenasUnicas(6);
            return new Bilhete($dezenas);
        });
    }

    public function gerarTabelaResultadoLoteria(): string
    {
        $bilhetePremiado = $this->gerarBilhetePremiado();
        $dezenasPremiadas = $bilhetePremiado->getDezenas();

        // Recupera os bilhetes dos tripulantes
        $bilhetesTripulante = $this->cache->get(self::CACHE_KEY_JOGOS);

        if (!$bilhetesTripulante) {
            throw new LoteriaException('Nenhum bilhete de tripulante encontrado.', 'bilhetesTripulante', 404);
        }

        // Inicia a tabela HTML
        $html = '<table border="1" cellpadding="10">';
        $html .= '<thead><tr><th colspan=2>'.implode(' ',$bilhetePremiado->getDezenas()).'</th></tr></thead><tbody>';
        $html .= '<tr><th>Jogo</th><th>Dezenas</th></tr></thead>';

        // Percorre os bilhetes dos tripulantes
        foreach ($bilhetesTripulante as $index => $bilhete) {
            $html .= '<tr>';
            $html .= '<td>Jogo ' . ($index + 1) . '</td>';
            $html .= '<td>';

            // Percorre as dezenas de cada bilhete
            foreach ($bilhete->getDezenas() as $dezena) {

                // Verifica se a dezena está no bilhete premiado
                if (in_array($dezena, $dezenasPremiadas)) {
                    // Destaca a dezena sorteada (ex: negrito e cor verde)
                    $html .= '<strong style="color:green;">' . $dezena . '</strong> ';
                } else {
                    // Exibe a dezena normalmente
                    $html .= $dezena . ' ';
                }
            }

            $html .= '</td></tr>';
        }

        // Fecha a tabela
        $html .= '</tbody></table>';

        // Retorna a tabela HTML
        return $html;
    }

    private function gerarDezenasUnicas(int $quantidade): array
    {
        $dezenas = [];
        while (count($dezenas) < $quantidade) {
            $dezena = rand(1, 60);
            if (!in_array($dezena, $dezenas)) {
                $dezenas[] = $dezena;
            }
        }
        sort($dezenas);
        return $dezenas;
    }
}
