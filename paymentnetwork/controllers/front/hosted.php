<?php

/**
 * @since 1.5.0
 * @uses  ModuleFrontControllerCore
 */
class PaymentNetworkHostedModuleFrontController extends ModuleFrontController {
    /**
     * @see FrontController::initContent()
     */
    public function initContent() {
        parent::initContent();

        $redirectUrl = $this->context->link->getModuleLink($this->module->name, 'validation', array(), true);
        if (Configuration::get('PAYMENT_NETWORK_DEBUG') === 'Y') {
            $redirectUrl .= '&XDEBUG_SESSION_START=paymentmodule';
        }

        $parameters = array_merge(
            $this->module->captureOrder($this->context),
            [
                'redirectURL' => $redirectUrl
            ]
        );

        $type = Configuration::get('PAYMENT_NETWORK_INTEGRATION_TYPE');
        if ($type === 'iframe') {
            $parameters['signature'] = \P3\SDK\Gateway::sign(
                $parameters,
                Configuration::get('PAYMENT_NETWORK_MERCHANT_PASSPHRASE')
            );

            // Replace http with https in Gateway URL
            $gatewayURL = str_ireplace('http://', 'https://', Configuration::get('PAYMENT_NETWORK_GATEWAY_URL'));

            // Always append end slash
            if (preg_match('/(\.php|\/)$/', $gatewayURL) == false) {
                $gatewayURL .= '/';
            }

            // If URL is missing /paymentform add it. Otherwise assume this is a CHF URL.
            if (preg_match('/paymentform(\/.*)?/', $gatewayURL) == false) {
                $gatewayURL .= 'paymentform/';
            }

            $this->context->smarty->assign(array(
                'frontend'             => Configuration::get('PAYMENT_NETWORK_FRONTEND'),
                'url'                  => $gatewayURL,
                'this_path'            => $this->module->getPathUri(),
                'this_path_ssl'        => Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->module->name . '/',
                'form'                 => $parameters,
            ));

            $this->setTemplate('module:paymentnetwork/views/templates/front/iframe_payment.tpl');
        } else {
            /** @var \P3\SDK\Gateway $gateway */
            $gateway = $this->module->gateway;

            $hostedRequest = $gateway->hostedRequest($parameters, false, $type === 'modal');
            echo $hostedRequest;
            die();
        }
    }
}
