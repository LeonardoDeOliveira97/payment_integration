<?php

require_once __DIR__ . '../../../../utils/Validator.php';

class CustomerValidator extends Validator
{
    public static function validate($data)
    {
        self::validateRequiredFields($data, ['name', 'email', 'tax_id']);

        if (gettype($data) === 'object') {
            self::validateEmail($data->email);
        } else if (gettype($data) === 'array') {
            self::validateEmail($data['email']);
        }
    }
}
