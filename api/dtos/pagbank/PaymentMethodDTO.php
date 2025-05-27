<?php

/**
 * PaymentMethod class represents a payment method with its type and associated brands.
 * Alloweds payment method types: CREDIT_CARD, DEBIT_CARD, BOLETO, PIX
 */
class PaymentMethodDTO
{
    /**
     * @var string The type of the payment method (e.g., CREDIT_CARD, DEBIT_CARD, BOLETO, PIX).
     */
    public $type;

    /**
     * @var array List of brands associated with the payment method.
     * Only used for CREDIT_CARD and DEBIT_CARD types.
     * If you don't know the brand, you can use addDefaultBrands() method to add all allowed brands.
     */
    public $brands =  [];

    public function __construct() {}

    public function toArray(): array
    {
        if (empty($this->brands)) {
            return [
                'type' => $this->type,
            ];
        }

        return [
            'type' => $this->type,
            'brands' => $this->brands,
        ];
    }

    public function addBrand(string $brand): void
    {
        if (!in_array($brand, $this->brands)) {
            $this->brands[] = $brand;
        }
    }

    public function addDefaultBrands(): void
    {
        $allowedBrands =
            [
                'PERSONALCARD',
                'UPBRASIL',
                'BANESECARD',
                'VISA',
                'MASTERCARD',
                'AMEX',
                'DINERS',
                'HIPERCARD',
                'HIPER',
                'AURA',
                'CABAL',
                'AVISTA',
                'PLENOCARD',
                'ELO',
                'GRANDCARD',
                'CARDBAN',
                'SOROCRED',
                'BRASILCARD',
                'VERDECARD',
                'JCB',
                'MAIS',
                'POLICARD',
                'VALECARD',
                'DISCOVER',
                'FORTBRASIL'
            ];

        foreach ($allowedBrands as $brand) {
            $this->addBrand($brand);
        }
    }
}
