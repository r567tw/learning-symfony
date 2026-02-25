<?php

namespace App\Service;

class TaxCalculator
{
    private float $taxRate;

    // 注意：這裡的 $taxRate 是 float，Symfony 無法自動知道是多少
    public function __construct(float $taxRate)
    {
        $this->taxRate = $taxRate;
    }

    public function calculate(float $amount): float
    {
        return $amount * (1 + $this->taxRate);
    }
}
