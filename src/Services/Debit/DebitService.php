<?php
namespace Dersonsena\IndicesFinanceiros\Services\Debit;

use DateTime;
use Dersonsena\IndicesFinanceiros\Indices\IndiceFinanceiroAbstract;
use Dersonsena\IndicesFinanceiros\Services\ServiceInterface;

class DebitService implements ServiceInterface
{
    /**
     * @var int
     */
    private $errorCode;

    /**
     * @var string
     */
    private $errorMessage = '';

    /**
     * @var FetcherInterface
     */
    private $fetcher;

    /**
     * @var ParserInterface
     */
    private $parser;

    public function __construct(FetcherInterface $fetcher, ParserInterface $parser)
    {
        $this->fetcher = $fetcher;
        $this->parser = $parser;
    }

    public static function newDebitService()
    {
        return new DebitService(new HTTPFetcher, new DOMScrapperParser);
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
