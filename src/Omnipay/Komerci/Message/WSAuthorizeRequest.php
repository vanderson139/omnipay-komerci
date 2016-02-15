<?php

namespace Omnipay\Komerci\Message;

/**
 * Komerci Authorize Request
 */
class WSAuthorizeRequest extends WSAbstractRequest
{

    protected $method = 'GetAuthorized';

    public function getData()
    {
        $this->validate('amount', 'filiacao', 'transacao', 'parcelas', 'card');

        /*
          card
          token
          amount
          currency
          description
          transactionId
          clientIp
          returnUrl
          cancelUrl

          'firstName',
          'lastName',
          'number',
          'expiryMonth',
          'expiryYear',
          'startMonth',
          'startYear',
          'cvv',
          'issueNumber',
          'type',
          'billingAddress1',
          'billingAddress2',
          'billingCity',
          'billingPostcode',
          'billingState',
          'billingCountry',
          'billingPhone',
          'shippingAddress1',
          'shippingAddress2',
          'shippingCity',
          'shippingPostcode',
          'shippingState',
          'shippingCountry',
          'shippingPhone',
          'company',
          'email'
         */
        $data = array(
            'Total' => sprintf("%.2F", round($this->getAmount() * 100) / 100),
            'Transacao' => '73', // 2-step authorization;
            'Parcelas' => '', // Only in the step Confirmation
            'Filiacao' => $this->getFiliacao(),
            'NumPedido' => $this->getTransactionId(),
            'Nrcartao' => $this->getCard()->getNumber(),
            'CVC2' => $this->getCard()->getCvv(),
            'Mes' => $this->getCard()->getExpiryMonth(),
            'Ano' => $this->getCard()->getExpiryYear(),
            'Portador' => $this->getCard()->getName(),
            'IATA' => '',
            'Distribuidor' => '',
            'Concentrador' => '',
            'TaxaEmbarque' => '',
            'Entrada' => '',
            'Numdoc1' => '',
            'Numdoc2' => '',
            'Numdoc3' => '',
            'Numdoc4' => '',
            'Pax1' => '',
            'Pax2' => '',
            'Pax3' => '',
            'Pax4' => '',
            'ConfTxn' => 'S',
            'Add_Data' => ''
        );

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->prepareSendData($data);
        return $this->response = new WSAuthorizeResponse($this, $httpResponse->xml());
    }
}
