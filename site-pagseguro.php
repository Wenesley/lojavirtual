<?php 

use \Hcode\Page;
use \Hcode\Model\User;
use \Hcode\PagSeguro\Config;
use \Hcode\PagSeguro\Transporter;
use \Hcode\Model\Order;


$app->get('/payment', function(){

	User::verifyLogin(false);

	$order = new Order();

	$order->getFromSession();

	$years = [];

	for ($y = date('Y'); $y < date('y')+14; $y++)
	{
		array_push($years, $y);
	}

	$page = new Page();

	$page->setTpl("payment", [
		"order"=>$order->getValues(),
		"msgError"=>Order::getError(),
		"years"=>$years,
		"pagseguro"=>[
			"urlJS"=>Config::getUrlJS(),
			"id"=>Transporter::createSession(),
			"maxInstallmentNoInterest"=>Config::MAX_INSTALLMENT_NO_INTEREST,
			"maxInstallment"=>Config::MAX_INSTALLMENT
		]
	]);
});

/*
//rota utilizada somente para testes
//pega id da sessao, não será utilizado.
//para esta, foi criado a classe Transporter de forma organizada
$app->get('/payment/pagseguro', function() {

	$client = new Client();
	$res = $client->request('POST', Config::getUrlSessions() . "?" . http_build_query(Config::getAuthentication()), [
		'verify'=>false //desabilita validação do certificado.
	]);

	echo $res->getBody()->getContents();

});
*/

?>