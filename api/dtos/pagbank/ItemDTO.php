<?php

class ItemDTO
{
    public string $reference_id;
    public string $name;
    public string $description;
    public int $quantity;
    public int $unit_amount;
    public string $image_url;

    public function __construct() {}

    public function toArray(): array
    {
        return [
            'reference_id' => $this->reference_id,
            'name' => $this->name,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'unit_amount' => $this->unit_amount,
            'image_url' => $this->image_url,
        ];
    }
}
