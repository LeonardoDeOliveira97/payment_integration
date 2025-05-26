<?php

class CustomerDTO
{
    public string $name;
    public string $email;
    public string $tax_id;

    public function __construct() {}

    public function toArray()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'tax_id' => $this->tax_id,
        ];
    }

    public function fromArray($data)
    {
        $this->name = $data['name'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->tax_id = $data['tax_id'] ?? null;
    }

    public function validate()
    {
        if (empty($this->id) || empty($this->name) || empty($this->email)) {
            throw new Exception("ID, name, and email are required fields.");
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format.");
        }
    }
}
