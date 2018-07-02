<?php

use Dersonsena\IndicesFinanceiros\Services\Debit\DebitService;
use Dersonsena\IndicesFinanceiros\Indices\IGPDIFGV;
use Dersonsena\IndicesFinanceiros\Indices\IGPMFGV;
use Dersonsena\IndicesFinanceiros\Indices\IPCFIPE;

require_once __DIR__ . '/vendor/autoload.php';

$debit = DebitService::newDebitService();
$debit->getIndicesByCurrentMonth();
$debit->getCurrentCotacaoByIndiceCode(IGPMFGV::getCodigo());
$debit->getCotacoesByIndiceCode(IGPMFGV::getCodigo());
