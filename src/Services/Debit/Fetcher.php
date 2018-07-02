<?php

namespace Dersonsena\IndicesFinanceiros\Services\Debit;

use Curl\Curl;
use ErrorException;
use Exception;

class Fetcher
{
    const URL = 'http://www.debit.com.br/aluguel10.php';

    /**
     * @var int
     */
    private $errorCode;

    /**
     * @var string
     */
    private $errorMessage;

    /**
     * @return string
     */
    public function getContent(): string
    {
        try {
            $curl = new Curl;
            $curl->get(static::URL);

            if ($curl->error) {
                throw new ErrorException($curl->error, $curl->errorCode);
            }

            return $curl->response;

        } catch (ErrorException $e) {
            $this->errorCode = $e->getCode();
            $this->errorMessage = $e->getMessage();

        } catch (Exception $e) {
            $this->errorCode = $e->getCode();
            $this->errorMessage = $e->getMessage();
        }
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
