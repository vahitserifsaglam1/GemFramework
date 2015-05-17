<?php
/**
 *  
 *  GemFramework Delete Builder -> delete sorgularý hazýrlanýr
 *  
 *  @package  Gem\Components\Database\Mode;
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 *   
 */
namespace Gem\Components\Database\Mode;

use Gem\Components\Database\Mode\ModeManager;
use Gem\Components\Database\Builders\Where;
use Gem\Components\Database\Base;


class Delete extends ModeManager
{
	
	public function __construct(Base $base)
	{
		
		$this->setBase($base);
		$this->useBuilders([
					
				'where' => new Where(),					
		]);
		
		$this->string = [
					
				'from' => $this->getBase()->getTable(),
				'where'  => null,
				'parameters' => [],
					
		];
		
		$this->setChield($this);
		
		$this->setChieldPattern('delete');
	}
			
		
}
	
