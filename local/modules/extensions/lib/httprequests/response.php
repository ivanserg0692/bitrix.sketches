<?php

namespace Extensions\HttpRequests;

/**
 * оберетка для хранения ответа REST запросов
 */
class Response
{
    /**
     * @param $code
     * @param $body
     */
    public function __construct(int $code, string $body)
    {
        $this->code = $code;
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    protected $code;
    protected $body;
}