<?php
/**
 *  
 *  GemFramework Veritabaný sýnýfý ana sýnýfý 
 *  
 *  # builder lerle ve diðer altyapýlarla iletiþimi saðlayacak
 *  
 *  @package Gem\Components\Database
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 * 
 */

namespace Gem\Components\Database;

use Gem\Components\Database\Starter;
use Gem\Components\Database\Traits\ConnectionManager;
use Gem\Components\Helpers\Config;
use Gem\Components\Database\Mode\Read;
use Gem\Components\Database\Mode\Update;
use Gem\Components\Database\Mode\Insert;
use Gem\Components\Database\Mode\Delete;



class Base extends Starter{
	
	use ConnectionManager,Config;
	
	
	public function __construct()
	{
		
		
		$configs = $this->getConfig('db');
		$this->connection = parent::__construct($configs);
	
	}
	
	/**
	 * Select iþleminde sorgu oluþturmak da kullanýlýr
	 * @param string $table
	 * @param callable $callable
	 * @return mixed
	 * @access public
	 */
	public function read($table, callable $callable = null)
	{
		
         $this->connect($table);
         $read = new Read($this);
         return $callable($read);
		
	}
	
	/**
	 * Update Ýþlemlerinde kullanýlýr
	 * @param string $table
	 * @param callable $callable
	 * @return mixed
	 */
	public function update($table, callable $callable = null)
	{
	
		$this->connect($table);
		$update = new Update($this);
		return $callable($update);
	
	}
	

	/**
	 * Insert Ýþlemlerinde kullanýlýr
	 * @param string $table
	 * @param callable $callable
	 * @return mixed
	 */
	public function insert($table, callable $callable = null)
	{
	
		$this->connect($table);
		$insert = new Insert($this);
		return $callable($insert);
	
	}
		

	/**
	 * Delete Ýþlemlerinde kullanýlýr
	 * @param string $table
	 * @param callable $callable
	 * @return mixed
	 */
	public function delete($table, callable $callable = null)
	{
	
		$this->connect($table);
		$delete = new Delete($this);
		return $callable($delete);
	
	}
	
	/**
	 * Dinamik method çaðrýmý
	 * @param string $method
	 * @param array $args
	 * @return mixed
	 */
	
	public function __call($method, array $args = [])
	{
		
		return call_user_func_array([$this->getConnection(),$method], $args);
		
	}
	
	
	
}
