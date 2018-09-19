<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use PagSeguro\Library as PagSeguroLibrary;
use PagSeguro\Services\Session as PagSeguroSession;
use PagSeguro\Services\Installment as PagSeguroInstallment;
use PagSeguro\Configuration\Configure as PagSeguroConfigure;
use PagSeguro\Domains\Requests\DirectPayment\CreditCard as PagSeguroCreditCard;

class PagSeguroController extends Controller
{
    public function __construct()
    {
        PagSeguroLibrary::initialize();
        PagSeguroLibrary::cmsVersion()->setName("Nome")->setRelease("1.0.0");
        PagSeguroLibrary::moduleVersion()->setName("Nome")->setRelease("1.0.0");
    }

    /*
     *path: /pagseguro/session
     */
    public function getSessionId() : JsonResponse
    {
        try {
            $sessionCode = PagSeguroSession::create(
                PagSeguroConfigure::getAccountCredentials()
            );

            return new JsonResponse([
                'sessionId' => $sessionCode->getResult(),
            ]);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()],400);
        }
    }

    /**
     *path: /pagseguro/creditCardPayment
     **/
    public function postCreditCardPayment(Request $request)
    {
        //parameters
        $creditCardToken    = $request->get('creditCardToken');
        $senderHash         = $request->get('senderHash');
        $donationAmount     = $request->get('donationAmount');

        //billing
        $street             = $request->get('street');
        $number             = $request->get('number');
        $neighborhood       = $request->get('neighborhood');
        $zipCode            = $request->get('zipCode');
        $city               = $request->get('city');
        $state              = $request->get('state');
        $complement         = $request->get('complement');

        $buyerEmail         = $request->get('buyerEmail');
        $buyerBirthDate     = $request->get('buyerBirthDate');
        $buyerName          = $request->get('buyerName');
        $buyerCardName      = $request->get('buyerCardName');
        $buyerCPF           = $request->get('buyerCPF');
        $buyerPhone         = $request->get('buyerPhone');

        //gather fields and post to pagseguro
        //Instantiate a new direct payment request, using Credit Card
        $creditCard = new PagSeguroCreditCard();

        /**
         * @todo Change the receiver Email
         */
        $creditCard->setReceiverEmail("janfrs3@gmail.com");

        // Set a reference code for this payment request. It is useful to identify this payment
        // in future notifications.
        $creditCard->setReference("LIBPHP000001");

        // Set the currency
        $creditCard->setCurrency("BRL");

        // Add an item for this payment request
        $creditCard->addItems()->withParameters(
            '0001',
            'Donation',
            1,
            $donationAmount
        );

        // Set your customer information.
        // If you using SANDBOX you must use an email @sandbox.pagseguro.com.br
        $creditCard->setSender()->setName($buyerName);
        $creditCard->setSender()->setEmail($buyerEmail);
        $creditCard->setSender()->setPhone()->withParameters(
            11,
            56273440
        );

        $creditCard->setSender()->setDocument()->withParameters(
            'CPF',
            $buyerCPF
        );

        $creditCard->setSender()->setHash($senderHash);

        $creditCard->setSender()->setIp('127.0.0.0');

        // Set shipping information for this payment request
        $creditCard->setShipping()->setAddress()->withParameters(
            $street,
            $number,
            $neighborhood,
            $zipCode,
            $city,
            $state,
            'BRA',
            $complement
        );

        //Set billing information for credit card
        $creditCard->setBilling()->setAddress()->withParameters(
            $street,
            $number,
            $neighborhood,
            $zipCode,
            $city,
            $state,
            'BRA',
            $complement
        );

        // Set credit card token
        $creditCard->setToken($creditCardToken);

        // Set the installment quantity and value (could be obtained using the Installments
        // service, that have an example here in \public\getInstallments.php)
        $creditCard->setInstallment()->withParameters(1, $donationAmount);

        // Set the credit card holder information
        $creditCard->setHolder()->setBirthdate($buyerBirthDate);
        $creditCard->setHolder()->setName($buyerName); // Equals in Credit Card

        $creditCard->setHolder()->setPhone()->withParameters(
            11,
            56273440
        );

        $creditCard->setHolder()->setDocument()->withParameters(
            'CPF',
            $buyerCPF
        );

        // Set the Payment Mode for this payment request
        $creditCard->setMode('DEFAULT');

        // Set a reference code for this payment request. It is useful to identify this payment
        // in future notifications.

        try {
            //Get the crendentials and register the boleto payment
            $result = $creditCard->register(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );
            echo "<pre>";
            print_r($result);
        } catch (Exception $e) {
            echo "</br> <strong>";
            die($e->getMessage());
        }
    }
}
