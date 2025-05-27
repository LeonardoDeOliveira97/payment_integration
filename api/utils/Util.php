<?php

class Util
{
    public static function transformDecimalToInteger($value)
    {
        $newValue = str_replace(',', '.', $value);

        if (is_numeric($newValue)) {
            return (int) ($newValue * 100);
        } else {
            throw new Exception("O valor '$value' não é numérico.");
        }
    }

    public static function calculateDiscountAmount($subtotal, $discountPercentage)
    {
        if ($discountPercentage < 0 || $discountPercentage > 100) {
            throw new Exception("Porcentagem de desconto deve estar entre 0 e 100.");
        }

        return (int) round($subtotal * ($discountPercentage / 100));
    }
}
