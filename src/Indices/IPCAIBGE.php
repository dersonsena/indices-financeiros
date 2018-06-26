<?php

namespace Dersonsena\IndicesFinanceiros\Indices;

class IPCAIBGE extends IndiceFinanceiroAbstract
{
    protected $nome = 'IPCA (IBGE)';

    public static function getCodigo(): int
    {
        return 130;
    }
}
