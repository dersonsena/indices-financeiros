<?php

namespace Dersonsena\IndicesFinanceiros\Services\Debit;

use DateTime;
use Dersonsena\IndicesFinanceiros\Indices\ICVDIEESE;
use Dersonsena\IndicesFinanceiros\Indices\IGPDIFGV;
use Dersonsena\IndicesFinanceiros\Indices\IGPMFGV;
use Dersonsena\IndicesFinanceiros\Indices\IndiceFinanceiroAbstract;
use Dersonsena\IndicesFinanceiros\Indices\INPCIBGE;
use Dersonsena\IndicesFinanceiros\Indices\IPCAIBGE;
use Dersonsena\IndicesFinanceiros\Indices\IPCFIPE;
use DOMDocument;
use DOMXPath;

class Parser
{
    public function parse(string $content)
    {
        $doc = new DOMDocument;
        libxml_use_internal_errors(true);
        $doc->loadHTML($content);

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

        $data = [];

        foreach ($map as $i => $className) {
            $data = $data + $this->parseIndice($tableNodeList[$i]->childNodes, $className);
        }

        return $data;
    }

    private function parseIndice($childNodes, string $className)
    {
        $rows = [];

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

            $rows[$indiceObj::getCodigo()][] = $indiceObj;
        }

        return $rows;
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
