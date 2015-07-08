<?php

	 namespace Gem\Components\View;
	 /**
	  * Bu interface ile sınıfın view dosyası olması gerektiğini söylüyoruz
	  * Interface ShouldBeView
	  * @package Gem\Components\View
	  */
	 interface ShouldBeView
	 {

		  public static function make ($fileName = '', $params = [ ]);

		  public function execute ();

	 }
