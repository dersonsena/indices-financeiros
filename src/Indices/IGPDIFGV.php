<?php

namespace Dersonsena\IndicesFinanceiros\Indices;

class IGPDIFGV extends IndiceFinanceiroAbstract
{
    protected $nome = 'IGP-DI (FGV)';

    public static function getCodigo(): int
    {
        return 100;
    }
}
