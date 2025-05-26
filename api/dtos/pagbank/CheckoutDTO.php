<?php

class CheckoutDTO
{
    public $id;
    public $reference_id;
    public $soft_descriptor;
    public $expiration_date;
    public CustomerDTO $customer;
    public $items = [];
    public $redirect_url;

    public function __construct() {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'reference_id' => $this->reference_id,
            'soft_descriptor' => $this->soft_descriptor,
            'expiration_date' => $this->expiration_date,
            'customer' => $this->customer->toArray(),
            'items' => array_map(fn($item) => $item->toArray(), $this->items),
            'redirect_url' => $this->redirect_url,
        ];
    }

    public function addItem(ItemDTO $item): void
    {
        $this->items[] = $item;
    }
}
