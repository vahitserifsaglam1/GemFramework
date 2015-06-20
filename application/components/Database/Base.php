<?php

/**
 *
 *  GemFramework Veritaban� s�n�f� ana s�n�f�
 *
 *  # builder lerle ve di�er altyap�larla ileti�imi sa�layacak
 *
 * @package Gem\Components\Database
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
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
use Gem\Components\Database\Traits\ModeManager;

class Base extends Starter
{

    use ConnectionManager,
        Config,
        ModeManager;

    public function __construct()
    {


        $configs = $this->getConfig('db');
        $this->connection = parent::__construct($configs);
    }

    /**
     * Select i�leminde sorgu olu�turmak da kullan�l�r
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
     * Update ��lemlerinde kullan�l�r
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
     * Insert ��lemlerinde kullan�l�r
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
     * Delete ��lemlerinde kullan�l�r
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
     * Dinamik method �a�r�m�
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, array $args = [])
    {

        if ($this->isMode($method)) {

            $return = $this->callMode($method, $args);
        } else {

            $return = call_user_func_array([$this->getConnection(), $method], $args);
        }

        return $return;
    }

}
