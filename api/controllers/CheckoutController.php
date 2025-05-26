<?php

require_once __DIR__ . '../../dtos/pagbank/validators/CheckoutValidator.php';
require_once __DIR__ . '../../services/PagBankService.php';
require_once __DIR__ . '../../dtos/pagbank/CheckoutDTO.php';
require_once __DIR__ . '../../dtos/pagbank/CustomerDTO.php';
require_once __DIR__ . '../../dtos/pagbank/ItemDTO.php';
require_once __DIR__ . '../../config/HttpResponses.php';
require_once __DIR__ . '../../utils/Util.php';

class CheckoutController
{
    private $pagbankService;

    public function __construct()
    {
        $this->pagbankService = new PagBankService();
    }

    public function createCheckout($request)
    {
        try {
            CheckoutValidator::validate($request);
            $checkout = new CheckoutDTO();
            $checkout->id = $request['id'];
            $checkout->reference_id = $request['reference_id'];
            $checkout->soft_descriptor = $request['soft_descriptor'];
            $checkout->redirect_url = $request['redirect_url'];

            // Expiration date (+3 days)
            $date = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
            $date->modify('+3 days');
            $expiration_date = $date->format('c');

            $checkout->expiration_date =  $expiration_date;

            $customer = new CustomerDTO();
            $customer->name = $request['customer']['name'];
            $customer->email = $request['customer']['email'];
            $customer->tax_id = $request['customer']['tax_id'];
            $checkout->customer = $customer;

            if (count($request['items']) == 0) {
                throw new Exception("Items cannot be empty");
            } else {
                foreach ($request['items'] as $item) {
                    $itemDTO = new ItemDTO();
                    $itemDTO->reference_id = $item['reference_id'];
                    $itemDTO->name = $item['name'];
                    $itemDTO->description = $item['description'];
                    $itemDTO->quantity = $item['quantity'];
                    $itemDTO->unit_amount = Util::transformDecimalToInteger($item['unit_amount']);
                    $itemDTO->image_url = $item['image_url'];

                    $checkout->addItem($itemDTO);
                }
            }

            $response = $this->pagbankService->createCheckout($checkout);

            return json_encode($response);
        } catch (Exception $e) {
            return httpResponses::sendError($e->getMessage());
        }

        return $response;
    }
}
