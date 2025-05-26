<?php

class Validator
{
    public static function validateRequiredFields($data, $fields)
    {
        foreach ($fields as $field) {

            if (gettype($data) === 'object') {
                if (empty($data->{$field})) {
                    throw new Exception("O campo '$field' é obrigatório.");
                }
            } else if (gettype($data) === 'array') {
                if (empty($data[$field])) {
                    throw new Exception("O campo '$field' é obrigatório.");
                }
            } else {
                throw new Exception("Tipo de campo inválido: " . gettype($field) . $data);
            }
        }
    }

    public static function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("E-mail em formato inválido.");
        }
    }

    public static function validateNumeric($value)
    {
        $newValue = str_replace(',', '.', $value);

        if (!is_numeric($newValue)) {
            throw new Exception("O valor '$value' não é numérico.");
        }
    }

    // Expected format ISO 8601: 'Y-m-d\TH:i:sP', ex: 2025-06-10T19:09:10-03:00
    public static function validateDateTime($dateTime)
    {
        $date = DateTime::createFromFormat('Y-m-d\TH:i:sP', $dateTime);
        if (!$date || $date->format('Y-m-d\TH:i:sP') !== $dateTime) {
            throw new Exception("Data e hora em formato inválido: '$dateTime'. Deve ser 'Y-m-d\TH:i:sP' (ex: 2025-06-10T19:09:10-03:00).");
        }
    }
}
