<?php

	 namespace Gem\Components\View;

	 use Gem\Components\Helpers\Config;
	 use Gem\Components\Helpers\String\Builder;
	 use Gem\Components\Helpers\String\Parser;

	 /**
	  * Bu sınıf GemFramework'deki view sınıflarını bağlar.
	  * Class Connector
	  * @package Gem\Components\Vıew
	  */
	 class Connector
	 {

		  use Parser, Builder, Config;

		  protected $autoload;
		  protected $fileName;
		  protected $params;
		  protected $headerBag;
		  protected $footerBag;

		  public function __construct ()
		  {
				$this->headerBag = new HeaderBag();
				$this->footerBag = new FooterBag();
				$view = $this->getConfig ('general')['view'];
				$this->headerFile ($view['headerFiles']);
				$this->footerFile ($view['footerFiles']);
		  }

		  /**
			* Autoload yapılıp yapılmayacağını kontrol eder
			* @param bool $au
			* @return $this
			*/
		  public function autoload ($au = false)
		  {

				$this->autoload = $au;

				return $this;
		  }

		  /**
			* Header dosyalarının atamasını yapar
			* @param array $file
			* @return $this
			*/
		  public function headerFile ($file = [ ])
		  {

				$this->headerBag->setViewHeaders ($file);

				return $this;

		  }

		  public function footerFile ($file = [ ])
		  {

				$this->footerBag->setViewFooters ($file);

				return $this;

		  }

		  /**
			*
			* @param array $language
			* @return \Gem\Components\View
			*
			*  [ 'dil' => [
			*   'file1','file2'
			*  ]
			*/
		  public function language ($language)
		  {

				if ( count ($language) > 0 && is_array ($language) ) {

					 foreach ( $language as $lang ) {

						  ## alt par�alama
						  foreach ( $lang as $langfile ) {

								$file = $this->joinDotToUrl ($langfile);
								$fileName = LANG . $langfile . '/' . $file . ".php";

								if ( file_exists ($fileName) ) {

									 $newParams = include $fileName;
									 $this->params = array_merge ($this->params, $newParams);
								}
						  }
					 }
				}


				return $this;

		  }

		  /**
			* Dosya  adını atar
			* @param string $fileName
			* @return $this
			*/
		  public function setFileName ($fileName = '')
		  {
				$this->fileName = $fileName;

				return $this;
		  }

		  /**
			* Kullanılacak parametreleri atar
			* @param array $params
			* @return $this
			*/
		  public function setParams ($params = [ ])
		  {
				$this->params = $params;

				return $this;
		  }

	 }
