<?php

class PagBankService
{
    public function createCheckout(CheckoutDTO $dto)
    {
        $payload = json_encode($dto->toArray());

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, PAGBANK_CHECKOUT_URL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer " . PAGBANK_TOKEN,
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}
