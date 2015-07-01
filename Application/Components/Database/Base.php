<?php

	 /**
	  *
	  *  GemFramework Veritaban� s�n�f� ana s�n�f�
	  *
	  *  # builder lerle ve di�er altyap�larla ileti�imi sa�layacak
	  *
	  * @package Gem\Components\Database
	  * @author vahitserifsaglam <vahit.serif119@gmail.com>
	  *
	  */

	 namespace Gem\Components\Database;

	 use Gem\Components\Database\Mode\Delete;
	 use Gem\Components\Database\Mode\Read;
	 use Gem\Components\Database\Mode\Update;
	 use Gem\Components\Database\Mode\Insert;
	 use Gem\Components\Database\Tools\BackUp;
	 use Gem\Components\Database\Traits\ConnectionManager;
	 use Gem\Components\Database\Traits\ModeManager;
	 use Gem\Components\Helpers\Config;


	 class Base extends Starter
	 {

		  use ConnectionManager,
				Config,
				ModeManager;

		  public function __construct ()
		  {


				$configs = $this->getConfig ('db');
				parent::__construct ($configs['connection']);
				$this->connection = $this->getDb ();
		  }

		  /**
			* Select i�leminde sorgu olu�turmak da kullan�l�r
			* @param string $table
			* @param callable $callable
			* @return mixed
			* @access public
			*/
		  public function read ($table, callable $callable = null)
		  {

				$this->connect ($table);
				$read = new Read($this);

				return $callable($read);
		  }

		  /**
			* Update ��lemlerinde kullan�l�r
			* @param string $table
			* @param callable $callable
			* @return mixed
			*/
		  public function update ($table, callable $callable = null)
		  {

				$this->connect ($table);
				$update = new Update($this);

				return $callable($update);
		  }

		  /**
			* Insert ��lemlerinde kullan�l�r
			* @param string $table
			* @param callable $callable
			* @return mixed
			*/
		  public function insert ($table, callable $callable = null)
		  {

				$this->connect ($table);
				$insert = new Insert($this);

				return $callable($insert);
		  }

		  /**
			* Delete delete işlemlerinde kullanılır
			* @param string $table
			* @param callable $callable
			* @return mixed
			*/
		  public function delete ($table, callable $callable = null)
		  {

				$this->connect ($table);
				$delete = new Delete($this);

				return $callable($delete);
		  }

		  /**
			* Veritabanını yedekler
			* @param string $tables Çekilecek tabloların adı, tüm tabloların çekilmesini istiyorsanız * girebilirisiz
			* @param string $src Dosyanın kaydedileceği yer
			* @return bool
			*/
		  public function backup ($tables = '*', $src = DATABASE)
		  {
				$backup = new BackUp($this->getConnection ());

				return $backup->backUp ($tables, $src);

		  }

		  /**
			* Yedeklenen veri tabanı dosyalarını yükler
			* @return bool
			*/
		  public function load ()
		  {
				$backup = new BackUp($this->getConnection ());

				return $backup->load ($this);

		  }

		  /**
			* Dinamik method çağrımı
			* @param string $method
			* @param array $args
			* @return mixed
			*/
		  public function __call ($method, array $args = [ ])
		  {

				if ( $this->isMode ($method) ) {

					 $return = $this->callMode ($method, $args);
				} else {

					 $return = call_user_func_array ([ $this->getConnection (), $method ], $args);
				}

				return $return;
		  }

	 }
