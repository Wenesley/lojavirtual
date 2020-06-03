<?php

namespace Hcode\PagSeguro;

/**
 * 
 */
class Config
{
	const SANDBOX = true;
	
	const SANDBOX_EMAIL = "wenesleysantos@gmail.com";
	const PRODUCTION_EMAIL = "wenesleysantos@gmail.com";

	const SANDBOX_TOKEN = "0E83D52BD9EC4A7B9F3CA06B8677F0E0";
	const PRODUCTION_TOKEN = "00bb758c-5b33-4b96-ad17-8f4b8d939dbcdf1ab5534cc1bd91a1799c1b9f1101151263-36ce-453e-ab2f-918aa7fd0d5b"; 

	const SANDBOX_SESSIONS = "https://ws.sandbox.pagseguro.uol.com.br/v2/sessions";
	const PRODUCTION_SESSIONS = "https://ws.pagseguro.uol.com.br/v2/sessions";

	public static function getAuthentication():array
	{

		if(Config::SANDBOX === true)
		{

			return [
				"email"=>Config::SANDBOX_EMAIL,
				"token"=>Config::SANDBOX_TOKEN
			];

		} 
		else
		{

			return [
				"email"=>Config::PRODUCTION_EMAIL,
				"token"=>Config::PRODUCTION_TOKEN
			];
		} 

	}

	public static function getUrlSessions():String
	{

		return (Config::SANDBOX === true) ? Config::SANDBOX_SESSIONS : Config::PRODUCTION_SESSIONS;

	}
	
}


?>