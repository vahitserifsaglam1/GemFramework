<?php

	 namespace Gem\Components\Database\Mode;

	 use Gem\Components\Database\Base;
	 use Gem\Components\Database\Traits\Where as TraitWhere;

	 class Insert extends ModeManager
	 {

		  use TraitWhere;

		  public function __construct (Base $base)
		  {

				$this->setBase ($base);


				$this->string = [

					 'from'       => $this->getBase ()->getTable (),
					 'insert'     => null,
					 'parameters' => [ ],
				];

				$this->setChield ($this);

				$this->setChieldPattern ('insert');
		  }

		  /**
			* Veritabanındaki role kısmının atamasını hazırlar
			* @param array $role
			* @return mixed
			*/
		  public function role (array $role = [ ])
		  {
				$role = implode (',', $role);

				return $this->set ([
					 'role' => $role
				]);
		  }


		  /**
			*
			* @param array $set
			* @return $this
			*/
		  public function set ($set = [ ])
		  {

				$insert = $this->databaseSetBuilder ($set);
				$this->string['insert'] .= $insert['content'];
				$this->string['parameters'] = array_merge ($this->string['parameters'], $insert['array']);

				return $this;
		  }

	 }
