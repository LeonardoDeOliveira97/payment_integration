<?php

require_once __DIR__ . '../../../../utils/Validator.php';

class ItemValidator extends Validator
{
    public static function validate($data)
    {
        self::validateRequiredFields($data, ['reference_id', 'name', 'description', 'quantity', 'unit_amount', 'image_url']);

        if (gettype($data) === 'object') {
            self::validateNumeric($data->quantity);
            self::validateNumeric($data->unit_amount);
        } else if (gettype($data) === 'array') {
            self::validateNumeric($data['quantity']);
            self::validateNumeric($data['unit_amount']);
        }
    }
}
