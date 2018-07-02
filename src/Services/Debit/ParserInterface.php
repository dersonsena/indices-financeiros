<?php

namespace Dersonsena\IndicesFinanceiros\Services\Debit;

interface ParserInterface
{
    public function parse(string $content): array;
}