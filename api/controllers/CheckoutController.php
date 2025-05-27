<?php

require_once __DIR__ . '../../dtos/pagbank/validators/CheckoutValidator.php';
require_once __DIR__ . '../../services/PagBankService.php';
require_once __DIR__ . '../../dtos/pagbank/CheckoutDTO.php';
require_once __DIR__ . '../../dtos/pagbank/CustomerDTO.php';
require_once __DIR__ . '../../dtos/pagbank/ItemDTO.php';
require_once __DIR__ . '../../dtos/pagbank/PaymentMethodDTO.php';
require_once __DIR__ . '../../dtos/pagbank/PaymentMethodConfigDTO.php';
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
            $checkout->discount_amount = $request['discount_amount'] ?? 0;
            $checkout->soft_descriptor = $request['soft_descriptor'];
            $checkout->redirect_url = $request['redirect_url'];

            // Expiration date (+3 days)
            $date = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
            $date->modify('+3 days');
            $expiration_date = $date->format('c');

            $checkout->expiration_date =  $expiration_date;

            // Customer information
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

            // Payment methods
            if (isset($request['payment_methods']) && is_array($request['payment_methods']) && count($request['payment_methods']) > 0) {

                $subtotal = 0;
                // Calculate the subtotal of items
                foreach ($checkout->items as $item) {
                    $subtotal += $item->unit_amount * $item->quantity;
                }

                foreach ($request['payment_methods'] as $paymentMethod) {
                    // Debit card
                    if ($paymentMethod['type'] === 'D') {
                        $paymentMethodDTO = new PaymentMethodDTO();
                        $paymentMethodDTO->type = 'DEBIT_CARD';
                        $paymentMethodDTO->addDefaultBrands();

                        $checkout->addPaymentMethod($paymentMethodDTO);

                        // Calculate the discount amount for debit card
                        $checkout->discount_amount = Util::calculateDiscountAmount($subtotal, $request['discount_percentage'] ?? 0);
                    }

                    // PIX
                    else  if ($paymentMethod['type'] === 'P') {
                        $paymentMethodDTO = new PaymentMethodDTO();
                        $paymentMethodDTO->type = 'PIX';

                        $checkout->addPaymentMethod($paymentMethodDTO);

                        // Calculate the discount amount for PIX
                        $checkout->discount_amount = Util::calculateDiscountAmount($subtotal, $request['discount_percentage'] ?? 0);
                    }

                    // Credit card
                    else if ($paymentMethod['type'] === 'C') {
                        $paymentMethodDTO = new PaymentMethodDTO();
                        $paymentMethodDTO->type = 'CREDIT_CARD';
                        $paymentMethodDTO->addDefaultBrands();

                        $checkout->addPaymentMethod($paymentMethodDTO);

                        if (isset($paymentMethod['config_options']) && is_array($paymentMethod['config_options'])) {
                            foreach ($paymentMethod['config_options'] as $option) {
                                $config = new PaymentMethodConfigDTO();
                                $config->type = 'CREDIT_CARD';

                                $config->addConfigOption($option['option'], $option['value']);
                                $checkout->addPaymentMethodConfig($config);
                            }
                        }
                    }

                    // Boleto
                    else if ($paymentMethod['type'] === 'B') {
                        $paymentMethodDTO = new PaymentMethodDTO();
                        $paymentMethodDTO->type = 'BOLETO';

                        $checkout->addPaymentMethod($paymentMethodDTO);
                    } else {
                        throw new Exception("Invalid payment method type: " . $paymentMethod['type']);
                    }
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
