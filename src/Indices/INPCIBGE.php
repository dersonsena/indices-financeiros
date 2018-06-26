<?php

namespace Dersonsena\IndicesFinanceiros\Indices;

class INPCIBGE extends IndiceFinanceiroAbstract
{
    protected $nome = 'INPC (IBGE)';

    public static function getCodigo(): int
    {
        return 140;
    }
}
