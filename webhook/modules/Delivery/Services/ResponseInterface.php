<?php

namespace Modules\Delivery\Services;

interface ResponseInterface
{
    /**
     * Get the response code
     *
     * @return int
     */
    public function getStatus();

    /**
     * Get the response content
     *
     * @return string
     */
    public function getBody();
}