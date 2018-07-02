<?php
namespace Dersonsena\IndicesFinanceiros\Services\Debit;

use DateTime;
use Dersonsena\IndicesFinanceiros\Indices\IndiceFinanceiroAbstract;
use Dersonsena\IndicesFinanceiros\Services\ServiceInterface;

class DebitService implements ServiceInterface
{
    private $errorCode;
    private $errorMessage = '';

    /**
     * @var Fetcher
     */
    private $fetcher;

    /**
     * @var Parser
     */
    private $parser;

    public function __construct(Fetcher $fetcher, Parser $parser)
    {
        $this->fetcher = $fetcher;
        $this->parser = $parser;
    }

    public function getProviderName(): string
    {
        return 'Debit';
    }

    public function getErrorCode(): int
    {
        return (int)$this->errorCode;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function getIndicesByCurrentMonth(): array
    {
        $indices = [];
        $parsedData = $this->parser->parse($this->fetcher->getContent());

        foreach ($parsedData as $code => $listaIndices) {
            $indices[$code] = [];

            foreach ($listaIndices as $indice) {
                if ((new DateTime)->format('m') === $indice->getData()->format('m')) {
                    $indices[$code] = $indice;
                    break;
                }
            }
        }

        return $indices;
    }

    public function getCotacoesByIndiceCode(int $indiceCode): array
    {
        $parsedData = $this->parser->parse($this->fetcher->getContent());

        $cotacoes = array_filter($parsedData, function ($listaIndices, $code) use ($indiceCode) {
            return $code == $indiceCode;
        }, ARRAY_FILTER_USE_BOTH);

        if (!$cotacoes) {
            return [];
        }

        return $cotacoes[$indiceCode];
    }

    public function getCurrentCotacaoByIndiceCode(int $indiceCode):? IndiceFinanceiroAbstract
    {
        $parsedData = $this->parser->parse($this->fetcher->getContent());

        foreach ($parsedData[$indiceCode] as $indice) {
            if ((new DateTime)->format('m') === $indice->getData()->format('m')) {
                return $indice;
            }
        }

        return null;
    }
}
