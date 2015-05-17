<?php
/**
 * 
 *  GemFramework Connection Manager Trait, veritabaný baðlantýsý ve baþlatýlýp sonlandýrýl
 *  masý bu sýnýfta yapýlacak
 *  
 *  @package  Gem\Components\Database\Traits;
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 */

namespace Gem\Components\Database\Traits;


trait ConnectionManager
{
	
	private $connection;
	
	private $connectedTable;
	
	/**
	 * Baðlantý sonlandýrýldý
	 */
	public function close()
	{
		
		$this->connection = null;
		
	}
	
	
	/**
	 * Kullanýlacak tabloyu seçer
	 * @param string $table
	 */
	
	public function connect($table)
	{
		
		$this->connectedTable = $table;
		
	}
	
	/**
	 * Seçilen tabloyu döndürür
	 * @return string
	 */
	
	public function getTable()
	{
		
		return $this->connectedTable;
		
	}
	
	/**
	 * 
	 * @return \PDO
	 */
	public function getConnection()
	{
		
		return $this->connection;
		
	}
	
}