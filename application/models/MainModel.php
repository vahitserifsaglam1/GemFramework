<?php
/**
 *
 *  Bu Sınıf GemFramework'un Ana Model sınıfıdır, her model bu sınıfı extends etmelidir.
 * @author vahitserifsaglam1 <vahit.serif119@gmail.com>
 * @copyright 2015, Vahit Şerif Sağlam
 */
namespace Gem\Models;

use Gem\Components\Database\Model;
use Gem\Components\Database\Mode\Read;

class MainModel extends Model
{

    private $called;
    private $setCollection = array();
    private $getCollection = array();

    public function __construct()
    {

        $this->called = get_called_class();
        $vars = get_class_vars($this->called);
        if (isset($vars['table'])) {

            $this->called = $vars['table'];

        }

    }

    /**
     * Dinamik olarak verileri atamaya yarar
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {

        $this->setCollection[$name] = $value;

    }

    /**
     * Dinamik olarak istenen veriler atanır
     * @param $name
     * @return $this
     */
    public function __get($name)
    {

        $this->getCollection[] = $name;
        return $this;

    }

    /**
     *  Verileri veritabanına ekler
     */
    public function insert()
    {

        $set = $this->setCollection;
        if (count($set) > 0) {
            self::insert($this->called, function ($mode) use ($set) {

                return $mode->set($set)
                       ->run();

            });
        }


    }

    /**
     *
     *  __get ile toplanan istek verileri ile basit bir olay döndürür
     *
     */

    public function read(){

        $get = $this->getCollection;
        $return = self::read($this->called, function(Read $mode) use($get){

            return $mode->select($get)
                   ->run();

        });

    }

}