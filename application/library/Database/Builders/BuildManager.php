<?php

namespace Gem\Components\Database\Builders;
use PDO;
class BuildManager
{
	
	/**
	 * 
	 * @var \PDO
	 */
	private $connection;
	
	private $query;
	
	private $params;
	
	/**
	 * Base Ataması yapar
	 * @param Base $base
	 */
	
	public function __construct(PDO $base)
	{
		
		$this->connection = $base;
		
	}
	
	/**
	 * Query Sorgusunu atar
	 * @param string $query
	 */
	
	public function setQuery($query)
	{
		
		$this->query = $query;
		
	}
	
	/**
	 * parametreleri atar
	 * @param array $params
	 */
	public function setParams($params = [])
	{
		

		$this->params = $params;
		
		
	}
	
	/**
	 * Sorguyu Yürütür
	 * @return PDOStatement
	 */
	
	public function run()
	{
		
		$prepare = $this->connection->prepare($this->query);
		$prepare->execute($this->params);
	    return $prepare;
		
	}
	
	
}