<?php
namespace Modules\Core\Traits;

trait CurrencyTrait
{
    protected $dollar = "$";

    /**
     * Format currency
     *
     * @param [string] $money
     * @param boolean $dollar
     * @return float
     */
    public function moneyFormat($money,$dollar = false)
    {
        $money = floatval(preg_replace("/[^0-9.]/","",$money));
        return $dollar ? $this->dollar.$money : $money;        
    }
}