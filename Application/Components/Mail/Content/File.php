<?php
	 namespace Gem\Components\Mail\Content;

	 use Gem\Components\Filesystem;
	 use Gem\Components\Mail\Content\Manager;

	 /**
	  *  belirli bir metinden yada uzak sunucudan veri çekmek için kullanılır.
	  * @package Gem\Components\Mail\Content
	  * @author vahitserifsaglam <vahit.serif119@gmail.com>
	  */
	 class File implements ManagerInterface
	 {

		  private $file;
		  private $content;


		  public function __construct ($filename = '')
		  {

				$this->file = Filesystem::getInstance ();
				if ( $read = $this->file->read ($filename, true) ) {

					 $this->content = $read;

				}
		  }

		  /**
			* İçeriği döndürür
			* @return mixed
			*/
		  public function getContent ()
		  {

				return $this->content;

		  }

		  public function setContent ($content)
		  {

				$this->content = $content;

				return $this;

		  }

	 }
