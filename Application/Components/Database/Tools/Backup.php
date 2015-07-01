<?php
	 /**
	  *  Bu Sınıf GemFramework'de Veritabanı' nı yedeklemede kullanılır.
	  * @author vahitserifsaglam <vahit.serif119@gmail.com>
	  *
	  */
	 namespace Gem\Components\Database\Tools;

	 use Gem\Components\Database\Builders\BuildManager;
	 use Gem\Components\Database\Mode\Insert;
	 use Gem\Components\Filesystem;

	 /**
	  * Class Backup
	  * @package Gem\Components\Database\Tools
	  */
	 class BackUp extends BuildManager
	 {


		  /**
			* @param Base $sql Database\Base sınıfına ait bir instance
			*/
		  public function __construct ($connection)
		  {

				parent::__construct ($connection);
		  }

		  /**
			* @param string $tables
			* @param string $src
			* @return bool
			*/
		  public function backUp ($tables = '*', $src = DATABASE)
		  {


				if ( $tables === '*' ) {
					 $tables = $this->getAllTables ();
				} elseif ( is_string ($tables) ) {
					 $tables = explode (',', $tables);
				}

				$content = null;

				$generateArray = [ ];

				foreach ( $tables as $table ) {

					 $content .= sprintf ('DROP TABLE %s', $table);
					 $this->setQuery (sprintf ('SHOW CREATE TABLE %s', $table));
					 $this->setParams ([ ]);
					 $fetch = (array)$this->fetch ();
					 $this->setQuery (sprintf ('SELECT * FROM %s', $table));
					 $this->setParams ([ ]);
					 $fetchTable = (array)$this->fetch ();
					 $generateArray[] = [
						  'createTable' => $fetch['Create Table'],
						  'params'      => $fetchTable,
						  'content'     => $content,
						  'table'       => $fetch['Table']
					 ];
				}

				$content = serialize ($generateArray);
				$fileName = sprintf ('%s%sbackup-%d-%s%s', DATABASE, 'Backup/', time (), md5 (implode (',', $tables)), '.backup');

				$file = Filesystem::getInstance ();
				if ( !$file->exists ($fileName) ) {
					 $file->touch ($fileName);

					 return $file->write ($fileName, $content);
				} else {
					 return false;
				}
		  }

		  /**
			*  BackUp dosyasını yükler
			* @return bool
			*/

		  public function load ($base = null)
		  {
				$path = DATABASE . 'Backup/*';
				$dirs = array_filter (glob ($path, GLOB_NOSORT), 'is_file');
				$file = Filesystem::getInstance ();
				foreach ( $dirs as $dir ) {
					 $read = $file->read (realpath ($dir));
					 $unserialize = unserialize ($read);
					 foreach ( $unserialize as $s ) {
						  $createTableQuery = $s['createTable'];
						  $params = $s['params'];
						  $content = $s['content'];
						  $table = $s['table'];


						  $this->setQuery ($content);
						  $this->setParams ();
						  $this->run (true);
						  $this->setQuery (sprintf ('CREATE TABLE %s', $table));
						  $this->setParams ();
						  $this->run (true);
						  $this->setQuery ($createTableQuery);
						  $this->setParams ([ ]);
						  $this->run (true);

						  $insert = $base->insert ($table, function (Insert $mode) use ($params) {

								return $mode->set ($params)->run ();

						  });

						  if ( $insert ) {
								return true;
						  }
					 }

				}

				return false;
		  }


		  /**
			* Tüm tabloları döndürür
			* @return array
			*/
		  private function getAllTables ()
		  {

				$this->setQuery ("SHOW TABLES");
				$this->setParams ([ ]);

				$fetchAll = $this->fetchAll ();
				$tables = [ ];

				foreach ( $fetchAll as $table ) {
					 $tables[] = $table[0];
				}

				return $tables;

		  }
	 }