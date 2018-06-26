<?php

use Dersonsena\IndicesFinanceiros\Indices\IPCFIPE;
use Dersonsena\IndicesFinanceiros\Services\Debit\DebitService;

require_once __DIR__ . '/vendor/autoload.php';

$debit = new DebitService;
$debit->getIndicesByCurrentMonth();
$debit->getCurrentCotacaoByIndiceCode(IPCFIPE::getCodigo());
$debit->getCurrentCotacaoByIndiceCode(IPCFIPE::getCodigo());
