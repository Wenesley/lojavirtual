<?php

namespace Hcode\PagSeguro;

class Config {

    const SANDBOX = true;
    
    const SANDBOX_EMAIL = "";
	const PRODUCTION_EMAIL = "";

	const SANDBOX_TOKEN = "";
	const PRODUCTION_TOKEN = ""; 

    const SANDBOX_SESSIONS = "";
    const PRODUCTION_SESSIONS = "";

    const SANDBOX_URL_JS = "";
    const PRODUCTION_URL_JS = "";

    const SANDBOX_URL_TRANSACTION = "";
    const PRODUCTION_URL_TRANSACTION = "";
    
    const SANDBOX_URL_NOTIFICATION = "";
	const PRODUCTION_URL_NOTIFICATION =	"";

    const MAX_INSTALLMENT_NO_INTEREST = 10;
    const MAX_INSTALLMENT = 10;

    const NOTIFICATION_URL = "";

    public static function getAuthentication():array
	{

		if (Config::SANDBOX === true)
		{

			return array(
				"email"=>Config::SANDBOX_EMAIL,
				"token"=>Config::SANDBOX_TOKEN
			);

		} else {

			return array(
				"email"=>Config::PRODUCTION_EMAIL,
				"token"=>Config::PRODUCTION_TOKEN
			);

		}

	}

	public static function getUrlSessions():string
	{

		return (Config::SANDBOX === true) ? Config::SANDBOX_SESSIONS : Config::PRODUCTION_SESSIONS;

	}

	public function getUrlJS()
	{

		return (Config::SANDBOX === true) ? Config::SANDBOX_URL_JS : Config::PRODUCTION_URL_JS;

	}

	public static function getUrlTransaction()
	{

		return (Config::SANDBOX === true) ? Config::SANDBOX_URL_TRANSACTION :
		Config::PRODUCTION_URL_TRANSACTION;

	}

	public static function getNotificationTransactionURL()
	{

		return (Config::SANDBOX === true) ? Config::SANDBOX_URL_NOTIFICATION :
		Config::PRODUCTION_URL_NOTIFICATION;

	}

}
