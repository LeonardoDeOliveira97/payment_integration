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
}
