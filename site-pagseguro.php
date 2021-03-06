<?php 

use \Hcode\Page;
use \Hcode\Model\User;
use \Hcode\PagSeguro\Config;
use \Hcode\PagSeguro\Transporter;
use \Hcode\PagSeguro\Document;
use \Hcode\PagSeguro\Address;
use \Hcode\PagSeguro\Phone;
use \Hcode\PagSeguro\Item;
use \Hcode\PagSeguro\Bank;
use \Hcode\PagSeguro\Payment;
use \Hcode\PagSeguro\Sender;
use \Hcode\PagSeguro\Shipping;
use \Hcode\PagSeguro\CreditCard;
use \Hcode\PagSeguro\CreditCard\Installment;
use \Hcode\PagSeguro\CreditCard\Holder;
use \Hcode\Model\Order;


$app->get('/payment/success/debit', function(){

	User::verifyLogin(false);

	$order = new Order();

	$order->getFromSession();

	$order->get((int)$order->getidorder());

	$page = new Page();

	$page->setTpl("payment-success-debit", [
		'order'=>$order->getValues()
	]);

});

$app->get('/payment/success/boleto', function(){

	User::verifyLogin(false);

	$order = new Order();

	$order->getFromSession();

	$order->get((int)$order->getidorder());

	$page = new Page();

	$page->setTpl("payment-success-boleto", [
		'order'=>$order->getValues()
	]);

});


$app->get('/payment/success', function(){

	User::verifyLogin(false);

	$order = new Order();

	$order->getFromSession();

	$page = new Page();

	$page->setTpl("payment-success", [
		'order'=>$order->getValues()
	]);

});

$app->post('/payment/debit', function(){

	User::verifyLogin(false);

	$order = new Order();

	$order->getFromSession();

	$order->get((int)$order->getidorder());

	$address = $order->getAddress();

	$cart = $order->getCart();

	$cpf = new Document(Document::CPF, $_POST['cpf']);

	$phone = new phone($_POST['ddd'], $_POST['phone']);

	$shippingAddress = new Address(

		$address->getdesaddress(),
		$address->getdesnumber(),
		$address->getdescomplement(),
		$address->getdesdistrict(),
		$address->getdeszipcode(),
		$address->getdescity(),
		$address->getdesstate(),
		$address->getdescountry()

	);

	$birthDate = new DateTime($_POST['birth']);

	$sender = new Sender($order->getdesperson(), $cpf, $birthDate, $phone, $order->getdesemail(), $_POST['hash']);	

	$shipping = new Shipping($shippingAddress, (float)$cart->getvlfreight(), Shipping::PAC);	

	$payment = new Payment($order->getidorder(), $sender, $shipping);

	foreach($cart->getProducts() as $product) {

		$item = new Item(
			(int)$product['idproduct'],
			$product['desproduct'],
			(float)$product['vlprice'],
			(int)$product['nrqtd']
		);

		$payment->addItem($item);
	}

	$bank = new Bank($_POST['bank']);

	$payment->setBank($bank);

	//$dom = new DOMDocument();	

	//$test = $creditCard->getDOMElement();

	//$testNode = $dom->importNode($test, true);

	//$dom->appendChild($testNode);

	//$dom = $payment->getDOMDocument();

	Transporter::sendTransaction($payment);

	echo json_encode([
		'success'=>true
	]);


	//var_dump($order->getValues());
	//var_dump($address->getValues());
	//var_dump($cart->getValues());



});

$app->post('/payment/boleto', function(){

	User::verifyLogin(false);

	$order = new Order();

	$order->getFromSession();

	$order->get((int)$order->getidorder());

	$address = $order->getAddress();

	$cart = $order->getCart();

	$cpf = new Document(Document::CPF, $_POST['cpf']);

	$phone = new phone($_POST['ddd'], $_POST['phone']);

	$shippingAddress = new Address(

		$address->getdesaddress(),
		$address->getdesnumber(),
		$address->getdescomplement(),
		$address->getdesdistrict(),
		$address->getdeszipcode(),
		$address->getdescity(),
		$address->getdesstate(),
		$address->getdescountry()

	);

	$birthDate = new DateTime($_POST['birth']);

	$sender = new Sender($order->getdesperson(), $cpf, $birthDate, $phone, $order->getdesemail(), $_POST['hash']);	

	$shipping = new Shipping($shippingAddress, (float)$cart->getvlfreight(), Shipping::PAC);	

	$payment = new Payment($order->getidorder(), $sender, $shipping);

	foreach($cart->getProducts() as $product) {

		$item = new Item(
			(int)$product['idproduct'],
			$product['desproduct'],
			(float)$product['vlprice'],
			(int)$product['nrqtd']
		);

		$payment->addItem($item);
	}

	$payment->setBoleto();

	//$dom = new DOMDocument();	

	//$test = $creditCard->getDOMElement();

	//$testNode = $dom->importNode($test, true);

	//$dom->appendChild($testNode);

	//$dom = $payment->getDOMDocument();

	Transporter::sendTransaction($payment);

	echo json_encode([
		'success'=>true
	]);


	//var_dump($order->getValues());
	//var_dump($address->getValues());
	//var_dump($cart->getValues());



});

$app->post('/payment/credit', function(){

	User::verifyLogin(false);

	$order = new Order();

	$order->getFromSession();

	$order->get((int)$order->getidorder());

	$address = $order->getAddress();

	$cart = $order->getCart();

	$cpf = new Document(Document::CPF, $_POST['cpf']);

	$phone = new phone($_POST['ddd'], $_POST['phone']);

	$shippingAddress = new Address(

		$address->getdesaddress(),
		$address->getdesnumber(),
		$address->getdescomplement(),
		$address->getdesdistrict(),
		$address->getdeszipcode(),
		$address->getdescity(),
		$address->getdesstate(),
		$address->getdescountry()

	);

	$birthDate = new DateTime($_POST['birth']);

	$sender = new Sender($order->getdesperson(), $cpf, $birthDate, $phone, $order->getdesemail(), $_POST['hash']);

	$holder = new Holder($order->getdesperson(), $cpf, $birthDate, $phone);

	$shipping = new Shipping($shippingAddress, (float)$cart->getvlfreight(), Shipping::PAC);

	$installment = new Installment((int)$_POST['installments_qtd'], (float)$_POST['installments_value']);

	$billingAddress = new Address(

		$address->getdesaddress(),
		$address->getdesnumber(),
		$address->getdescomplement(),
		$address->getdesdistrict(),
		$address->getdeszipcode(),
		$address->getdescity(),
		$address->getdesstate(),
		$address->getdescountry()


	);

	$creditCard = new CreditCard($_POST['token'], $installment, $holder, $billingAddress);

	$payment = new Payment($order->getidorder(), $sender, $shipping);

	foreach($cart->getProducts() as $product) {

		$item = new Item(
			(int)$product['idproduct'],
			$product['desproduct'],
			(float)$product['vlprice'],
			(int)$product['nrqtd']
		);

		$payment->addItem($item);
	}

	$payment->setCreditCard($creditCard);

	//$dom = new DOMDocument();	

	//$test = $creditCard->getDOMElement();

	//$testNode = $dom->importNode($test, true);

	//$dom->appendChild($testNode);

	//$dom = $payment->getDOMDocument();

	Transporter::sendTransaction($payment);

	echo json_encode([
		'success'=>true
	]);


	//var_dump($order->getValues());
	//var_dump($address->getValues());
	//var_dump($cart->getValues());



});

$app->get('/payment', function(){

	User::verifyLogin(false);

	$order = new Order();

	$order->getFromSession();

	$years = [];

    for ($y = date('Y'); $y < date('Y')+14; $y++)
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