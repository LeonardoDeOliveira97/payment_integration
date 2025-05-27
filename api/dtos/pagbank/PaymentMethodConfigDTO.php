<?php

/**
 * This class allows you to configure payment methods.
 * It is used to define the type of payment method and its configuration options.
 * Only used for CREDIT_CARD and DEBIT_CARD types.
 * 
 */
class PaymentMethodConfigDTO
{
    /**
     * @var string The type of the payment method (e.g., CREDIT_CARD, DEBIT_CARD).
     */
    public $type;

    /**
     * @var array Configuration options for the payment method.
     * Supported keys:
     * - INSTALLMENTS_LIMIT: int - Defines the maximum number of installments for payment.
     * - INTEREST_FREE_INSTALLMENTS: int - Specifies the number of installments whose interest will be assumed by the seller.
     */
    public $config_options = [];

    public function __construct() {}

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'config_options' => $this->config_options,
        ];
    }

    public function addConfigOption(string $type, $value): void
    {
        $this->config_options[] = [
            'type' => $type,
            'value' => $value,
        ];
    }
}
