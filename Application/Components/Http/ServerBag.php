<?php

	 namespace Gem\Components\Http;

	 class ServerBag extends RequestHeadersBag
	 {

		  /**
			*
			* Server Değişkenindeki Http headerleri atar.
			*
			*/
		  public function __construct ()
		  {

				parent::__construct ();
				$headers = [ ];
				$server = $this->getServer ();
				foreach ( $server as $name => $value ) {
					 if ( substr ($name, 0, 5) == 'HTTP_' ) {

						  $name = str_replace (' ', '-', ucwords (strtolower (str_replace ('_', ' ', substr ($name, 5)))));
						  $headers[ $name ] = $value;
					 } else if ( $name == "CONTENT_TYPE" ) {
						  $headers["Content-Type"] = $value;
					 } else if ( $name == "CONTENT_LENGTH" ) {
						  $headers["Content-Length"] = $value;
					 }
				}

				$headers['Method'] = $_SERVER['REQUEST_METHOD'];
				$this->headers = array_merge ($this->headers, $headers);

		  }

	 }
