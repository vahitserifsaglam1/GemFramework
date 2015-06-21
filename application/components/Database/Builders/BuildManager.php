<?php

namespace Gem\Components\Database\Builders;

use Gem\Components\Database\Helpers\Pagination;
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
     * Sorguyu Y�r�t�r
     * @return PDOStatement
     */
    public function run()
    {

        $prepare = $this->connection->prepare($this->query);
        $prepare->execute($this->params);
        return $prepare;
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

}
