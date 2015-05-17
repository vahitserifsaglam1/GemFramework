<?php
/**
 * 
 *  GemFramework Veritabanı pdo instance oluşturma sınıfı 
 *  
 *  @package Gem\Components\Database
 *  
 *  @author vahitserifsaglam1 <vahit.serif119@gmail.com>
 *  
 *  @copyright MyfcYazilim
 * 
 */
namespace Gem\Components\Database;
use PDO;

class Starter
{
	
	
	public function __construct($options = [])
	{

		
		$host = $options['host'] ?: '';
		$database = $options['db'] ?: '';
		$username = $options['username'] ?: '';
		$password = $options['password'] ?: '';
		$charset = $options['charset'] ?: 'utf-8';
		
	
		try
		{
			
			$pdo = new PDO("mysql:host=$host;dbname=$database",$username,$password);
			$pdo->query("SET CHARSET {$charset}");
			return $pdo;
			
		}catch (\PDOException $e)
		{
			
			throw new \Exception($e->getMessage());
			
		}
		
		
		
		
		
 		
	}
	
}