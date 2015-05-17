<?php
/**
 * 
 *  GemFramework Database Read Mode -> veritabanýndan veri okumakda kullanýlýr
 * 
 *  @package Gem\Components\Database\Mode
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 * 
 */

 namespace Gem\Components\Database\Mode;
 use Gem\Components\Database\Base;
 use Gem\Components\Database\Mode\ModeManager;
 use Gem\Components\Database\Builders\Where;
 use Gem\Components\Database\Builders\Select;
 use Gem\Components\Database\Builders\Order;
 use Gem\Components\Database\Traits\Builder;
 use Gem\Components\Database\Builders\Limit;
			 
 class Read extends ModeManager{
 	
    use Builder;
    
    private  $as;
    
 	public function __construct(Base $base)
 	{
 		
 		$this->setBase($base);
 		$this->useBuilders([
 				
 				'where' => new Where(),
 				'select' => new Select(),
 				'order' => new Order(),
 				'limit' => new Limit()
 				
 		]);
 		 		
 		$this->string = [
 				
 				'select' => null,
 				'from' => $this->getBase()->getTable(),
 				'where'  => null,
 				'order'  => null,
 				'limit' => null,
 				'parameters' => [],
 				
 		];
 		
 		$this->setChield($this);
 		
 		$this->setChieldPattern('read');
 		
 	}
 	
 	/**
 	 * Select sorgusu oluþturur
 	 * @param string $select
 	 */
 	
 	public function select($select = null)
 	{
 	 		
 	  $this->string['select'] =  $this->useBuilder('select')
 	                              ->select($select,$this->cleanThis());
 	  
 	
 	  return $this;
 	  
 	}
	
	
	private function cleanThis()
	{
		
		return new static($this->getBase());
		
	}
 	
 	/**
 	 * Order Sorgusu oluþturur
 	 * @param string $order
 	 * @param string $type
 	 * @return \Gem\Components\Database\Mode\Read
 	 */
 	public function order($order, $type = 'DESC')
 	{
 		
 		$this->string['order'] .= $this->useBuilder('order')
 		->order($order, $type);
 		
 		return $this;
 		
 	}
 	
 	public function create($as, $select)
 	{
 		
 		$this->setAs($as);

 		return $this->select($select);
 		
 	}
 	
 	/**
 	 * Limit sorgusu oluþturur
 	 * @param string $limit
 	 * @return \Gem\Components\Database\Mode\Read
 	 */
 	public function limit($limit)
 	{
 		
 		$this->string['limit'] .= $this->useBuilder('limit')
 		->limit($limit);
 		
 		return $this;
 	}
 	
 	/**
 	 * 
 	 * @param string $as
 	 * @return \Gem\Components\Database\Mode\Read
 	 */
   public function setAs($as)
   {
   	
   	$this->as = $as;
   	return $this;
   	
   }
   
   /**
    * As i döndürür
    * @return string
    */
   
   public function getAs()
   {
   	
   	return $this->as;
   	
   }
 	
 }