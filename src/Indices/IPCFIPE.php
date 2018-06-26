<?php

namespace Dersonsena\IndicesFinanceiros\Indices;

class IPCFIPE extends IndiceFinanceiroAbstract
{
    protected $nome = 'IPC (FIPE)';

    public static function getCodigo(): int
    {
        return 120;
    }
}