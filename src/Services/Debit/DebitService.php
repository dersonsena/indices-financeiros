<?php
namespace Dersonsena\IndicesFinanceiros\Services\Debit;

use Curl\Curl;
use DateTime;
use Dersonsena\IndicesFinanceiros\Indices\ICVDIEESE;
use Dersonsena\IndicesFinanceiros\Indices\IGPDIFGV;
use Dersonsena\IndicesFinanceiros\Indices\IGPMFGV;
use Dersonsena\IndicesFinanceiros\Indices\IndiceFinanceiroAbstract;
use Dersonsena\IndicesFinanceiros\Indices\INPCIBGE;
use Dersonsena\IndicesFinanceiros\Indices\IPCAIBGE;
use Dersonsena\IndicesFinanceiros\Indices\IPCFIPE;
use Dersonsena\IndicesFinanceiros\Services\IService;
use DOMDocument;
use DOMXPath;
use ErrorException;
use Exception;

class DebitService implements IService
{
    private $url = 'http://www.debit.com.br/aluguel10.php';
    private $data = [];
    private $content = '';
    private $errorCode;
    private $errorMessage = '';

    public function __construct()
    {
        try {
            $curl = new Curl;
            $curl->get($this->url);

            if ($curl->error) {
                $this->errorCode = $curl->errorCode;
                $this->errorMessage = $curl->errorMessage;
                return;
            }

            $this->content = $curl->response;
            $this->parse();
            $curl->close();

        } catch (ErrorException $e) {
            $this->errorCode = $e->getCode();
            $this->errorMessage = $e->getMessage();

        } catch (Exception $e) {
            $this->errorCode = $e->getCode();
            $this->errorMessage = $e->getMessage();
        }
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

        foreach ($this->data as $code => $listaIndices) {
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
        return $this->data[$indiceCode];
    }

    public function getCurrentCotacaoByIndiceCode(int $indiceCode): IndiceFinanceiroAbstract
    {
        foreach ($this->data[$indiceCode] as $indice) {
            if ((new DateTime)->format('m') === $indice->getData()->format('m')) {
                return $indice;
            }
        }
    }

    private function parse()
    {
        $doc = new DOMDocument;
        libxml_use_internal_errors(true);
        $doc->loadHTML($this->content);

        $xpath = new DOMXPath($doc);
        $tableNodeList = $xpath->query("//table[@class='listagem']/tbody");

        $map = [
            0 => IGPDIFGV::class,
            1 => IGPMFGV::class,
            2 => IPCFIPE::class,
            3 => IPCAIBGE::class,
            4 => INPCIBGE::class,
            5 => ICVDIEESE::class
        ];

        foreach ($map as $i => $className) {
            $this->parseIndice($tableNodeList[$i]->childNodes, $className);
        }
    }

    private function parseIndice($childNodes, string $className)
    {
        foreach ($childNodes as $i => $node) {
            if ($i === 4) {
                break;
            }

            $data = $this->getDateTimeObjFromMonthYearFormat($node->childNodes[1]->textContent);
            $percentual = str_replace('%', '', $node->childNodes[5]->textContent);
            $percentual = (float)trim(str_replace(',', '.', $percentual));
            $indice = (float)trim(str_replace(',', '.', $node->childNodes[3]->textContent));

            /** @var IndiceFinanceiroAbstract $indiceObj */
            $indiceObj = new $className($data, $percentual, $indice);

            $this->data[$indiceObj::getCodigo()][] = $indiceObj;
        }
    }

    private function getDateTimeObjFromMonthYearFormat(string $monthYearString)
    {
        $monthList = [
            'Jan' => '01', 'Fev' => '02', 'Mar' => '03', 'Abr' => '04', 'Mai' => '05', 'Jun' => '06',
            'Jul' => '07', 'Ago' => '08', 'Set' => '09', 'Out' => '10', 'Nov' => '11', 'Dez' => '12'
        ];

        list ($month, $year) = explode('/', $monthYearString);

        return new DateTime("{$year}-{$monthList[$month]}-01");
    }
}
