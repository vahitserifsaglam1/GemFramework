<?php

/**
 *
 *  GemFramework Veritaban� pdo instance olu�turma s�n�f�
 *
 * @package Gem\Components\Database
 *
 * @author vahitserifsaglam1 <vahit.serif119@gmail.com>
 *
 * @copyright MyfcYazilim
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

        if(!isset($options['driver']))
            $driver= 'pdo';
        else
            $driver = $options['driver'];



        if(!isset($options['type']))
            $type= 'mysql';
        else
        $type = $options['type'];


        switch($driver){

            case 'pdo':

                try {

                    $db = new PDO("$type:host=$host;dbname=$database", $username, $password);
                    $db->query("SET CHARSET {$charset}");
                    return $db;
                } catch (\PDOException $e) {

                    throw new \Exception($e->getMessage());
                }

                break;
            case 'mysqli':

                $db = new \mysqli($host,$username,$password, $database);

                if($db->connect_errno > 0){
                    throw new \Exception('Bağlantı işlemi başarısız [' . $db->connect_error . ']');
                }

                return $db;
                break;

        }

    }

}
