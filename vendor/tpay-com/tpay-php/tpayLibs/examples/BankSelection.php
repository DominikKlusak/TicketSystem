<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\examples;
use tpayLibs\src\_class_tpay\Utilities\Util;
use tpayLibs\src\_class_tpay\PaymentForms\PaymentBasicForms;

include_once 'config.php';
include_once 'loader.php';


class BankSelectionExample extends PaymentBasicForms
{
    public function __construct()
    {
        $this->merchantSecret = 'demo';
        $this->merchantId = 1010;
        parent::__construct();
    }

    /**
     * Get bank selection by sending data array
     */
    public function getBankForm()
    {

        $config = array(
            'amount' => $_SESSION['bankCena'],
            'description' => 'Opłata w Nowym Sklepie',
            'crc' => '100020003000',
            'result_url' => 'http://example.pl/examples/notificationBasic.php?transaction_confirmation',
            'result_email' => 'mojnowysklep1@interia.pl',
            'return_url' => 'http://localhost/ticket/sklep/zamowienie.php',
            'email' => 'mojnowysklep1@interia.pl',
            'name' => $_SESSION['bankImie'],
        );

        $form = $this->getBankSelectionForm($config, false, true, null, true);

        echo $form;
    }

    /**
     * Get simple banks list presented as tiles without any other elements
     */
    public function getSimpleBanksForm()
    {
        echo $this->getSimpleBankList(false, false);
    }

}
(new Util())->setLanguage('pl');
(new BankSelectionExample())->getBankForm();

