<?php

/**
 * @since 1.5.0
 * @uses  ModuleFrontControllerCore
 */
class PaymentNetworkPaymentFailedModuleFrontController extends ModuleFrontController {

    /**
     * @see FrontController::initContent()
     */
    public function initContent() {

        parent::initContent();

        $outcome = Tools::getvalue('outcome');
        $transaction_id = Tools::getvalue('transaction_id');
        $response_message = Tools::getvalue('response_message');

        $this->context->smarty->assign(array(
            'outcome'          => ($outcome === 'accepted' ?? 'failed'),
            'transaction_id'   => $transaction_id,
            'response_message' => $response_message,
        ));

        $this->setTemplate('module:paymentnetwork/views/templates/front/payment_failed.tpl');
    }
}
