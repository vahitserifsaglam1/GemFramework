<?php
	 namespace Gem\Components;
	 class Benchmark
	 {
		  /**
			* @var $memoryusage         Ram Kullanımını Ölçer
			*/
		  public $memoryusage;
		  /**
			* @var $microtime           Zamanı ölçer
			*/
		  public $microtime;

		  /**
			* Yeni bir zaman dilimi oluşturur
			* @param string $name
			* @return $this
			*/

		  public function micro ($name)
		  {
				$this->microtime[ $name ] = microtime ();

				return $this;
		  }

		  /**
			* zaman Farkını döndürür
			* @param string $baslangic
			* @param string $son
			* @param integer $decimals
			* @return string
			*/
		  public function elapsedTime ($baslangic, $son, $decimals = 4)
		  {
				list( $start1, $start2 ) = explode (' ', $this->microtime[ $baslangic ]);
				list( $finish2, $finish3 ) = explode (' ', $this->microtime[ $son ]);
				$start = $start1 + $start2;
				$finish = $finish2 + $finish3;

				return number_format (( $finish - $start ), $decimals);
		  }

		  /**
			* Ram kullanımını döndürür
			* @param string $name
			* @return $this
			*/
		  public function memory ($name)
		  {
				$this->memoryusage[ $name ] = memory_get_usage (true);

				return $this;
		  }

		  /**
			* Ram kullanımını karşılaştırır
			* @param string $start
			* @param string $finish
			* @return Ambigous <number, boolean>
			*/
		  public function usedMemory ($start, $finish)
		  {

				if ( isset( $this->memoryusage[ $start ] ) && isset( $this->memoryusage[ $finish ] ) ) {
					 $start = $this->memoryusage[ $start ];
					 $finish = $this->memoryusage[ $finish ];

					 return ( isset( $start ) && isset( $finish ) ) ? $finish - $start : false;

				}

		  }

		  /**
			* include edilen dosyaları döndürür
			* @return mixed:
			*/
		  public function includedFiles ()
		  {
				if ( function_exists ('get_included_files') ) return get_included_files ();
		  }
	 }
