<?php

namespace Ispahbod\Zibal;

use GuzzleHttp\Exception\GuzzleException;
use Ispahbod\Zibal\core\Request;
use Ispahbod\Zibal\core\Verify;

class Zibal
{
    /**
     * Merchant ID for Zibal
     * @var string
     */
    protected string $merchantId;

    /**
     * Constructor for Zibal class
     * @param $merchant_id
     */
    public function __construct($merchant_id)
    {
        $this->merchantId = $merchant_id;
    }

    /**
     * @throws GuzzleException
     */
    public function verify(string $authority): Verify
    {
        return new Verify($this->merchantId, $authority);
    }

    public function payment(): Request
    {
        return new Request($this->merchantId);
    }
}
