<?php

namespace Dersonsena\IndicesFinanceiros\Indices;

class ICVDIEESE extends IndiceFinanceiroAbstract
{
    protected $nome = 'ICV (DIEESE)';

    public static function getCodigo(): int
    {
        return 150;
    }
}
