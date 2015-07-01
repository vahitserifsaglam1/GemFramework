<?php
	 /**
	  *  Bu Sınıf AccessSecurity Sınıfını kullanıma hazırlar
	  * @author vahitserifsaglam <vahit.serif119@gmail.com>
	  */
	 namespace Gem\Manager\Providers;

	 use Gem\Components\Security\AccessSecurity;

	 /**
	  * Class AccessSecurityProvider
	  * @package Gem\Manager\Providers
	  */
	 class AccessSecurityProvider
	 {

		  /**
			* Kullancıların var olması gerek bilgiler
			* @var array
			*/
		  private $allowedParams = [

				'allowedLanguage' => 'ch-CH'

		  ];

		  /**
			* Bilgiler Uyuşmadığı zaman çıkacak uyarı
			* @var string
			*/
		  private $message = 'Bu Sayfaya Erişim Yetkiniz Yok';


		  public function __construct ()
		  {
				$access = new AccessSecurity();
				$access->setConfig ($this->allowedParams)
					 ->setMessage ($this->message)
					 ->run ();
		  }

	 }