<?php

/**
 * @since 1.5.0
 * @uses  ModuleFrontControllerCore
 */
class PaymentNetworkPaymentModuleFrontController extends ModuleFrontController {

    /**
     * @see FrontController::initContent()
     */
    public function initContent() {

        parent::initContent();

        $outcome = Tools::getvalue('outcome');
        $response_message = Tools::getvalue('response_message');
        $order_url = Tools::getvalue('order_url');

        $this->context->smarty->assign(array(
            'outcome' => ($outcome === 'accepted' ?? 'failed'),
            'response_message' => $response_message,
            'order_url' => $order_url,
        ));

        $this->setTemplate('module:paymentnetwork/views/templates/front/payment_confirmation.tpl');
    }
}
