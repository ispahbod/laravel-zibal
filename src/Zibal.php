<?php

namespace Ispahbod\Zarinpal;

use Ispahbod\Zarinpal\core\Request;
use Ispahbod\Zarinpal\core\Verify;

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

    public function verify(array $array)
    {
        return new Verify($this->merchantId, $array);
    }

    public function newPaymnet()
    {
        return new Request($this->merchantId);
    }
}
