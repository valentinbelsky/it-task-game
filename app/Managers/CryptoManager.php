<?php

namespace App\Managers;
use JetBrains\PhpStorm\Pure;

class CryptoManager
{
    private $key;

    public function __construct() {
        $this->key = openssl_random_pseudo_bytes(32);
    }

    public function computeHMAC($move): bool|string
    {
        return hash_hmac('sha256', $move, $this->key);
    }

    #[Pure] public function getKey(): string
    {
        return bin2hex($this->key);
    }
}