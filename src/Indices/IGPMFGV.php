<?php

namespace Dersonsena\IndicesFinanceiros\Indices;

class IGPMFGV extends IndiceFinanceiroAbstract
{
    protected $nome = 'IGP-M (FGV)';

    public static function getCodigo(): int
    {
        return 110;
    }
}
