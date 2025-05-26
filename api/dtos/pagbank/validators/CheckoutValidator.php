<?php

require_once __DIR__ . '../../../../utils/Validator.php';
require_once __DIR__ . '../../validators/ItemValidator.php';
require_once __DIR__ . '../../validators/CustomerValidator.php';

class CheckoutValidator extends Validator
{
    public static function validate($data)
    {
        self::validateRequiredFields($data, ['reference_id', 'expiration_date', 'customer', 'items']);

        if (gettype($data) === 'object') {
            self::validateDateTime($data->expiration_date);
            self::validateCustomer($data->customer);
            
            self::validateItems($data->items);

        } else if (gettype($data) === 'array') {
            self::validateDateTime($data['expiration_date']);
            self::validateCustomer($data['customer']);
            self::validateItems($data['items']);
        }
    }

    private static function validateCustomer($customer)
    {
        CustomerValidator::validate($customer);
    }

    private static function validateItems($items)
    {
        foreach ($items as $item) {
            ItemValidator::validate($item);
        }
    }
}
