<?php

namespace Gem\Components\Database\Builders;

use Gem\Components\Database\Helpers\Pagination;
use PDO;
use PDOStatement;
use mysqli_stmt;


class BuildManager
{

    /**
     *
     * @var \PDO
     */
    private $connection;
    private $query;
    private $params = [];

    /**
     * Base Ataması yapar
     * @param Base $base
     */
    public function __construct($base)
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
     * Sorguyu Oluşturur
     * @return PDOStatement
     */
    public function run()
    {

        $prepare = $this->connection->prepare($this->query);
        if ($prepare instanceof PDOStatement) {

             $prepare->execute($this->params);

        }elseif($prepare instanceof mysqli_stmt) {

            $s = "";
            foreach ($this->params as $param) {

                if (is_string($param)) {
                    $s .= "s";
                } elseif (is_integer($param)) {
                    $s .= "i";
                }

            }

             if(count($this->params) < 1){
                 $param_arr = [];
             }else{
                 $param_arr = array_merge([$s], $this->params);
             }


             call_user_func_array([$prepare, 'bind_param'], $this->refValues($param_arr));
             $prepare->execute();

        }

        return $prepare;
    }

    private function refValues($arr){
        if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+
        {
            $refs = array();
            foreach($arr as $key => $value)
                $refs[$key] = &$arr[$key];
            return $refs;
        }
        return $arr;
    }

    /**
     * Sayfalama işlemini yapar
     *  ['url' => 'asdasd/asdasd/:page', 'now' = 0]
     * @param array $action
     * @return string
     */
    public function pagination($action = [], $return = true)
    {

        $pagination = new Pagination();
        $pagination->setCount($this->run()->rowCount());
        $paginate = $pagination->paginate($action);
        if ($return) {

            return $paginate;
        } else {

            echo $paginate;
        }
    }

    public function fetch($fetchAll = false){

        $query = $this->run();

        if($query instanceof PDOStatement){

            if($fetchAll)
                return $query->fetchAll();
            else
                return $query->fetch(PDO::FETCH_OBJ);

        }elseif($query instanceof mysqli_stmt){

            $query = $query->get_result();
            if($fetchAll)
                return $query->fetch_all();
            else
                return $query->fetch_object();

        }else{

             throw new \Exception(sprintf('Girdiğiniz veri tipi geçerli bir query değil. Tip:%s',gettype($query)));

        }

    }

    /**
     * Tüm işlemleri döndürür
     * @return array|mixed|object|\stdClass
     * @throws \Exception
     */

    public function fetchAll(){

        return $this->fetch(true);

    }

    /**
     * Eşleşen içerik sayısını döndürür
     * @return int
     */
    public function rowCount(){

        $query = $this->run();

        if($query instanceof PDOStatement){
            return $query->rowCount();
        }elseif($query instanceof mysqli_stmt){
            $query = $query->get_result();
            return $query->num_rows;
        }

    }


}
