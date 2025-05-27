<?php

class CheckoutDTO
{
    public $id;
    public $reference_id;
    public $discount_amount;
    public $soft_descriptor;
    public $expiration_date;
    public CustomerDTO $customer;
    public $items = [];
    public $payment_methods = [];
    public $payment_methods_config = [];
    public $redirect_url;

    public function __construct() {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'reference_id' => $this->reference_id,
            'discount_amount' => $this->discount_amount ?? 0,
            'soft_descriptor' => $this->soft_descriptor,
            'expiration_date' => $this->expiration_date,
            'customer' => $this->customer->toArray(),
            'items' => array_map(fn($item) => $item->toArray(), $this->items),
            'redirect_url' => $this->redirect_url,
            'payment_methods' => $this->payment_methods,
            'payment_methods_config' => $this->payment_methods_config,

        ];
    }

    public function addItem(ItemDTO $item): void
    {
        $this->items[] = $item;
    }

    public function addPaymentMethod(PaymentMethodDTO $payment_method): void
    {
        $this->payment_methods[] = $payment_method->toArray();
    }

    public function addPaymentMethodConfig(PaymentMethodConfigDTO $config): void
    {
        $this->payment_methods_config[] = $config->toArray();
    }
}
