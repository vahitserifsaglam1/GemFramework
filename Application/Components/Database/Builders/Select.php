<?php

	 /**
	  *
	  *  GemFramework Builders Select Trait -> select sorgular� burada olu�turulur
	  *
	  * @package Gem\Components\Database\Builders
	  * @author vahitserifsaglam <vahit.serif119@gmail.com>
	  *
	  */

	 namespace Gem\Components\Database\Builders;

	 use Gem\Components\Helpers\String\Builder;

	 class Select
	 {

		  use Builder;

		  public function select ($select = null, $base = null)
		  {

				$s = '';
				## de�er dizi ise string e �eviriyoruz

				if ( is_string ($select) ) {

					 $s = $this->replaceString (".", ",", $select);
				} elseif ( is_array ($select) ) {

					 foreach ( $select as $sel ) {

						  if ( is_string ($sel) ) {

								$s .= $sel . ',';
						  } elseif ( is_callable ($sel) ) {


								$s .= $this->selectCallable ($select, $base);
						  }
					 }

					 $s = rtrim ($s, ",");
				} elseif ( is_callable ($select) ) {

					 $s = $this->selectCallable ($select, $base);
				}

				return $s;
		  }

		  /**
			*
			* @param mixed $select
			* @param mixed $base
			* @return string
			*/
		  private function selectCallable ($select, $base)
		  {


				$response = call_user_func_array ($select, $base);
				$as = $response->getAs ();
				$query = $response->getQuery ();
				$select = "($query) as $as";

				return $select;
		  }

	 }
