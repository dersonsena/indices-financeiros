<?php

use Dersonsena\IndicesFinanceiros\Indices\IGPDIFGV;
use Dersonsena\IndicesFinanceiros\Indices\IGPMFGV;
use Dersonsena\IndicesFinanceiros\Indices\IPCFIPE;
use Dersonsena\IndicesFinanceiros\Services\Debit\DebitService;
use Dersonsena\IndicesFinanceiros\Services\Debit\Fetcher;
use Dersonsena\IndicesFinanceiros\Services\Debit\Parser;

require_once __DIR__ . '/vendor/autoload.php';

$debit = new DebitService(new Fetcher, new Parser);
$debit->getIndicesByCurrentMonth();
$debit->getCurrentCotacaoByIndiceCode(IGPMFGV::getCodigo());
