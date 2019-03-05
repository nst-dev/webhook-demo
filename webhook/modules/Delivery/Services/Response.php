<?php

namespace Modules\Delivery\Services;

class Response implements ResponseInterface
{
    const STATUS_SUCCESS = 200;

    /**
     * @var int
     */
    public $status;

    /**
     * @var string
     */
    public $body;

    /**
     * Response constructor
     *
     * @param int $status
     * @param string $body
     */
    public function __construct($status, $body = null)
    {
        $this->status = (int)$status;
        $this->body = $body;
    }

    /**
     * Get the response code
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the response content
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
}