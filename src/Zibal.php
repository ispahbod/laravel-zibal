<?php

namespace Ispahbod\Zibal;

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
     * @param string $merchantId Merchant ID for Zibal
     */
    public function __construct($merchant_id)
    {
        $this->merchantId = $merchant_id;
    }

    public function verify(string $authority): Verify
    {
        return new Verify($this->merchantId, $authority);
    }

    public function payment(): Request
    {
        return new Request($this->merchantId);
    }
}
