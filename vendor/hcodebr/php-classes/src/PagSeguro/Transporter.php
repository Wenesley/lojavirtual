<?php

namespace Hcode\PagSeguro;

use \GuzzleHttp\Client;
use Hcode\Model\Order;


class Transporter {

	public static function createSession()
	{

		$client = new Client();
		$res = $client->request('POST', Config::getUrlSessions() . "?" . http_build_query(Config::
			getAuthentication()), [
				'verify'=>false //desabilita validação do certificado.
			]);

		$xml = simplexml_load_string($res->getBody()->getContents());

		return ((String)$xml->id); //já estamos retornando o id para o template.
	}

	public static function sendTransaction(Payment $payment)
	{

		$client = new Client();
		
		$res = $client->request('POST', Config::getUrlTransaction() . "?" . http_build_query
		(Config::getAuthentication()), [
			"verify"=>false,
			"headers"=>[
				"Content-Type"=>"application/xml"
			],
			"body"=>$payment->getDOMDocument()->saveXml()
		]);
		
		$xml = simplexml_load_string($res->getBody()->getContents());

		$order = new Order();

		$order->get((int)$xml->reference);

		$order->setPagSeguroTransactionResponse(
			(string)$xml->code,
			(float)$xml->grossAmount,
			(float)$xml->discountAmount,
			(float)$xml->feeAmount,
			(float)$xml->netAmount,
			(float)$xml->extraAmount,
			(string)$xml->paymentLink
		);
		
		return $xml;

		//return ((String)$xml->id); //já estamos retornando o id para o template.

	}


}
?>