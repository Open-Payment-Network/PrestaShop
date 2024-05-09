<?php

/**
 * @since 1.5.0
 * @uses  ModuleFrontControllerCore
 */
class PaymentNetworkPaymentConfirmationModuleFrontController extends ModuleFrontController {

    /**
     * @see FrontController::initContent()
     */
    public function initContent() {

        parent::initContent();

        $outcome = Tools::getvalue('outcome');
        $transaction_id = Tools::getvalue('transaction_id');

        $this->context->smarty->assign(array(
            'outcome' => ($outcome === 'accepted' ?? 'failed'),
            'transaction_id' => $transaction_id,
        ));

        $this->setTemplate('module:paymentnetwork/views/templates/front/payment_confirmation.tpl');
    }
}
