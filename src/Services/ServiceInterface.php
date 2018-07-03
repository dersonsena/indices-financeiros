<?php

namespace Dersonsena\IndicesFinanceiros\Services;

interface ServiceInterface
{
    public function getProviderName(): string;
    public function getErrorCode(): int;
    public function getErrorMessage(): string;
    public function getIndicesByCurrentMonth(): array;
    public function getCotacoesByIndiceCode(int $indiceCode): array;
    public function getCurrentCotacaoByIndiceCode(int $indiceCode);
}
