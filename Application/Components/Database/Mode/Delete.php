<?php

	 /**
	  *
	  *  GemFramework Delete Builder -> delete sorgular� haz�rlan�r
	  *
	  * @package  Gem\Components\Database\Mode;
	  * @author vahitserifsaglam <vahit.serif119@gmail.com>
	  * @copyright (c) 2015, MyfcYazilim
	  */

	 namespace Gem\Components\Database\Mode;

	 use Gem\Components\Database\Base;
	 use Gem\Components\Database\Builders\Where;

	 class Delete extends ModeManager
	 {

		  public function __construct (Base $base)
		  {

				$this->setBase ($base);
				$this->useBuilders ([

					 'where' => new Where(),
				]);

				$this->string = [

					 'from'       => $this->getBase ()->getTable (),
					 'where'      => null,
					 'parameters' => [ ],
				];

				$this->setChield ($this);

				$this->setChieldPattern ('delete');
		  }

	 }
