<?php

declare(strict_types=1);

class LoteriaDTO
{
    private int $jogos;
    private int $dezenas;
    private bool $novo_jogo;

    public function __construct(array $data)
    {
        $this->validate($data);
        $this->jogos = $data['jogos'];
        $this->dezenas = $data['dezenas'];
        $this->novo_jogo = isset($data['novo_jogo']) ? $data['novo_jogo'] : false;
    }

    private function validate(array $data): void
    {
        if (!isset($data['jogos'])) {
            throw new LoteriaException("Informe a quantidade de jogos", "jogos", 400);
        }

        if (isset($data['jogos']) && ($data['jogos'] < 1 || $data['jogos'] > 50)) {
            throw new LoteriaException("Informe a quantidade de jogos entre 1 e 50", "jogos", 400);
        }

        if (!isset($data['dezenas'])) {
            throw new LoteriaException("Informe a dezena entre 6 e 10", "dezenas", 400);
        }

        if (isset($data['dezenas']) && ($data['dezenas'] < 6 || $data['dezenas'] > 10)) {
            throw new LoteriaException("Informe a dezena entre 6 e 10", "dezenas", 400);
        }

    }

    public function getJogos(): int
    {
        return $this->jogos;
    }

    public function getDezenas(): int
    {
        return $this->dezenas;
    }

    public function getNovoJogo(): bool
    {
        return $this->novo_jogo;
    }
}