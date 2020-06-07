<?php
	
	namespace Hcode\PagSeguro;

	class Address {

		private $street;
		private $number;
		private $complement;
		private $district;
		private $postalCode;
		private $city;
		private $state;
		private $country;


		public function __construct(string $street, string $number, string $complement, string $district, string $postalCode, string $city, string $state, string $country) {


			if(!$street)
			{
				throw new Exception("Informe o logradouro do endereço.");				
			}
			if(!$number)
			{
				throw new Exception("Informe o número do endereço");
			}
			if(!$complement)
			{
				throw new Exception("Informe o complemento do endereço");
			}
			if(!$district)
			{
				throw new Exception("Informe o bairro do endereço");
			}
			if(!$postalCode)
			{
				throw new Exception("Informe o CEP do endereço");
			}
			if(!$city)
			{
				throw new Exception("Informe a cidade do endereço");
			}
			if(!$state)
			{
				throw new Exception("Informe o estado do endereço");
			}
			if(!$country)
			{
				throw new Exception("Informe o país do endereço");
			}

			$this->street =  $street;
			$this->number =  $number;
			$this->complement =  $complement;
			$this->district =  $district;
			$this->postalCode =  $postalCode;
			$this->city =  $city;
			$this->state =  $state;
			$this->country =  $country;

		}

		public function getDOMElement($node = "address"):DOMElement
		{

			$dom = new DOMDocument();

			$address = $dom->createElement($node);
			$address = $dom->appendChild($address);

			$street = $dom->createElement("street", $this->street);
			$street = $document->appendChild($street);

			$number = $dom->createElement("number", $this->number);
			$number = $document->appendChild($number);

			$complement = $dom->createElement("complement", $this->complement);
			$complement = $document->appendChild($complement);

			$district = $dom->createElement("district", $this->district);
			$district = $document->appendChild($district);

			$postalCode = $dom->createElement("postalCode", $this->postalCode);
			$postalCode = $document->appendChild($postalCode);

			$city = $dom->createElement("city", $this->city);
			$city = $document->appendChild($city);

			$state = $dom->createElement("state", $this->state);
			$state = $document->appendChild($state);

			$country = $dom->createElement("country", $this->country);
			$country = $document->appendChild($country);

			return $address;
		}
		
	}

?>