<?php
/**
 * 
 *  GemFramework Builders Order Trait -> order sorguları burada oluşturulur
 *  
 *  @package Gem\Components\Database\Builders
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 * 
 */
namespace Gem\Components\Database\Builders;

class Order
{
	
	
   public function order($id,$type = 'DESC')
   {
   	
   	  return "ORDER BY {$id} {$type}";
   	
   }
	
	
}