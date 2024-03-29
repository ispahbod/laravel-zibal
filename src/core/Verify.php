<?php

namespace Ispahbod\Zibal\core;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Verify
{
    /**
     * Merchant ID for Zibal
     * @var string
     */
    protected string $merchantId;
    protected array $response = [];
    protected Client $client;

    const SSL = false;

    /**
     * Constructor for Zibal class
     * @param string $merchantId Merchant ID for Zibal
     * @param string $authority
     * @throws GuzzleException
     */
    public function __construct(string $merchantId, string $authority)
    {
        $this->merchantId = $merchantId;
        $this->client = new Client();
        $url = "https://gateway.zibal.ir/v1/verify";
        if (!empty($authority)) {
            $json = array_filter([
                'merchant' => $this->merchantId,
                'trackId' => $authority,
            ]);
            try {
                $response = $this->client->post($url, [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'cache-control' => 'no-cache',
                        'Accept' => 'application/json'
                    ],
                    'json' => $json,
                    'verify' => false
                ]);
                $statusCode = $response->getStatusCode();
                if ($statusCode == 200) {
                    $body = $response->getBody();
                    $content = $body->getContents();
                    $this->response = json_decode($content, true);
                }
            } catch (Exception) {
                // Handle exceptions if needed
            }
        }
    }

    public function getMessage()
    {
        if (isset($this->response['message'])) {
            return $this->response['message'];
        }
        return null;
    }


    public function paidAt()
    {
        if (isset($this->response['paidAt'])) {
            return $this->response['paidAt'];
        }
        return null;
    }

    public function getCardHash()
    {
        if (isset($this->response['cardNumber'])) {
            return $this->response['cardNumber'];
        }
        return null;
    }

    public function getCardPan()
    {
        if (isset($this->response['card_pan'])) {
            return $this->response['card_pan'];
        }
        return null;
    }

    public function getDescription()
    {
        if (isset($this->response['description'])) {
            return $this->response['description'];
        }
        return null;
    }

    public function getAmount()
    {
        if (isset($this->response['amount'])) {
            return $this->response['amount'];
        }
        return null;
    }

    public function getOrderId()
    {
        if (isset($this->response['orderId'])) {
            return $this->response['orderId'];
        }
        return null;
    }

    public function getRefNumber()
    {
        if (isset($this->response['refNumber'])) {
            return $this->response['refNumber'];
        }
        return null;
    }

    /**
     * Check if the payment is paid successfully
     * @return bool
     */
    public function isPaid(): bool
    {
        if (isset($this->response['status']) && ($this->response['status'] == 1 || $this->response['status'] == 2)) {
            return true;
        }
        return false;
    }


    /**
     * Get the response code
     * @return string|null
     */
    public function getCode(): ?string
    {
        if (isset($this->response['result'])) {
            return $this->response['result'];
        }
        return null;
    }

    /**
     * Get the response data
     * @return array|null
     */
    public function getData(): ?array
    {
        return $this->response;
    }
}
