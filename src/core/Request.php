<?php

namespace Ispahbod\Zarinpal\core;

use GuzzleHttp\Client;

class Request
{
    /**
     * Merchant ID for Zibal
     * @var string
     */
    protected string $merchantId;
    /**
     * Sandbox mode flag
     * @var bool
     */
    protected bool $sandbox = false;
    /**
     * Language setting
     * @var string
     */
    protected string $lang;
    /**
     * Guzzle HTTP Client instance
     * @var Client
     */
    protected Client $client;
    /**
     * Amount value for the payment
     * @var int
     */
    protected int $amountValue;
    /**
     * Callback URL after payment
     * @var string
     */
    protected string $descriptionValue;
    /**
     * Order ID for the payment
     * @var int
     */
    protected string $callbackUrl;
    /**
     * Order ID for the payment
     * @var int
     */
    protected int $orderId;
    /**
     * Metadata associated with the payment
     * @var array
     */
    protected array $metadata;
    /**
     * Mobile number associated with the payment
     * @var string
     */
    protected string $mobileValue;
    const SSL = false;

    /**
     * Constructor for Zibal class
     * @param string $merchantId Merchant ID for Zibal
     */
    public function __construct(string $merchantId = '')
    {
        $this->client = new Client();
        $this->merchantId = $merchantId;
    }

    /**
     * Enable or disable sandbox mode
     * @param bool $sandbox Sandbox mode flag
     * @return $this
     */

    /**
     * Set the mobile number for the payment
     * @param int $mobile Mobile number
     * @return $this
     */
    public function mobile(string $mobile)
    {
        $this->mobileValue = $mobile;
        return $this;
    }


    /**
     * Set the order ID for the payment
     * @param int $id Order ID
     * @return $this
     */
    public function order(int $id)
    {
        $this->orderId = $id;
        return $this;
    }

    /**
     * Set the description for the payment
     * @param string $description Payment description
     * @return $this
     */
    public function description(string $description)
    {
        $this->descriptionValue = $description;
        return $this;
    }

    /**
     * Set metadata for the payment
     * @param array $array Metadata array
     * @return $this
     */
    public function metadata(array $array)
    {
        $this->metadata = $array;
        return $this;
    }

    /**
     * Set the callback URL for the payment
     * @param string $url Callback URL
     * @return $this
     */
    public function callback(string $url)
    {
        $this->callbackUrl = $url;
        return $this;
    }

    /**
     * Set the amount for the payment
     * @param mixed $amount Payment amount
     * @return $this
     */
    public function amount($amount)
    {
        $this->amountValue = (int)$amount;
        return $this;
    }

    public function get()
    {
        $url = "https://gateway.zibal.ir/v1/request";
        $data = [];
        $json = array_filter([
            'merchant' => $this->merchantId,
            'amount' => $this->amountValue,
            'description' => $this->descriptionValue ?? 'empty',
            'callbackUrl' => $this->callbackUrl ?? null,
            'mobile' => $this->mobileValue ?? null,
            'orderId' => $this->orderId ?? null,
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
                $data = json_decode($content, true);
            }
        } catch (\Exception $e) {

        }
        return new Response($data);
    }
}
