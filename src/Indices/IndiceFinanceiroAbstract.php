<?php

namespace Dersonsena\IndicesFinanceiros\Indices;

use DateTime;

abstract class IndiceFinanceiroAbstract
{
    /**
     * @var string
     */
    protected $nome = 'SEM NOME';

    /**
     * @var DateTime
     */
    private $data;

    /**
     * @var float
     */
    private $percentual;

    /**
     * @var float
     */
    private $indice;

    abstract public static function getCodigo(): int;

    public function __construct(DateTime $data, float $percentual, float $indice = null)
    {
        $this->data = $data;
        $this->percentual = $percentual;
        $this->indice = $indice;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getData(): DateTime
    {
        return $this->data;
    }

    public function getIndice(): float
    {
        return $this->indice;
    }

    public function getPercentual(): float
    {
        return $this->percentual;
    }
}
