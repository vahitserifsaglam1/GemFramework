<?php
	 /**
	  * Created by PhpStorm.
	  * User: vserifsaglam
	  * Date: 24.6.2015
	  * Time: 20:44
	  */

	 namespace Gem\Components\Http;

	 use Gem\Components\Http\Response;

	 /**
	  * Bu sınıf GemFramework' de kullanılmak üzere tasarlanmıştır, Json Response leri oluşturmak üzere tasarlanmıştır
	  * Class JsonResponse
	  * @package Gem\Components\Http
	  */
	 class JsonResponse extends Response
	 {

		  public function __construct ($content = '', $statusCode = 200)
		  {

				$this->setContentType ('application/json');
				parent::__construct ($content, $statusCode);


		  }

		  /**
			* Yeni bir instance oluşturur
			* @param string $content
			* @param int $statusCode
			* @return static
			*/
		  public static function create ($content = '', $statusCode = 200)
		  {

				return new static($content, $statusCode);

		  }

	 }
