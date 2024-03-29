<?php

namespace Ispahbod\Zibal\core;

class Response
{
    protected array $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    public function getPaymentUrl(): ?string
    {
        if (isset($this->response['trackId'])) {
            return "https://gateway.zibal.ir/start/" . $this->response['trackId'];
        }
        return null;
    }

    public function getAuthority(): ?string
    {
        if (isset($this->response['trackId'])) {
            return $this->response['trackId'];
        }
        return null;
    }

    public function getData(): ?array
    {
        if (!empty($this->response)) {
            return $this->response;
        }
        return null;
    }

    public function getCode()
    {
        if (isset($this->response['result'])) {
            return $this->response['result'];
        }
        return null;
    }

    public function getMessage()
    {
        if (isset($this->response['message'])) {
            return $this->response['message'];
        }
        return null;
    }

    public function isSuccessful(): bool
    {
        if (!isset($this->response['result'])) {
            return false;
        }
        return true;
    }
}