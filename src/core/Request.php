<?php

namespace Ispahbod\Zibal\core;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Request
{
    /**
     * Merchant ID for Zibal
     * @var string
     */
    protected string $merchantId;
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
     * Set the mobile number for the payment
     * @param string $mobile Mobile number
     * @return $this
     */
    public function mobile(string $mobile): self
    {
        $this->mobileValue = $mobile;
        return $this;
    }

    /**
     * Set the order ID for the payment
     * @param int $id Order ID
     * @return $this
     */
    public function order(int $id): self
    {
        $this->orderId = $id;
        return $this;
    }

    /**
     * Set the description for the payment
     * @param string $description Payment description
     * @return $this
     */
    public function description(string $description): self
    {
        $this->descriptionValue = $description;
        return $this;
    }

    /**
     * Set metadata for the payment
     * @param array $array Metadata array
     * @return $this
     */
    public function metadata(array $array): self
    {
        $this->metadata = $array;
        return $this;
    }

    /**
     * Set the callback URL for the payment
     * @param string $url Callback URL
     * @return $this
     */
    public function callback(string $url): self
    {
        $this->callbackUrl = $url;
        return $this;
    }

    /**
     * Set the amount for the payment
     * @param mixed $amount Payment amount
     * @return $this
     */
    public function amount(int $amount): self
    {
        $this->amountValue = $amount;
        return $this;
    }

    public function get(): Response
    {
        $json = array_filter([
            'merchant' => $this->merchantId,
            'amount' => $this->amountValue,
            'description' => $this->descriptionValue ?? 'empty',
            'callbackUrl' => $this->callbackUrl ?? null,
            'mobile' => $this->mobileValue ?? null,
            'orderId' => $this->orderId ?? null,
        ]);
        try {
            $response = $this->client->request('POST', "https://gateway.zibal.ir/v1/request", [
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
        } catch (GuzzleException) {}
        return new Response($data ?? []);
    }
}
