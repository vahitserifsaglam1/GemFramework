<?php

    namespace Gem\Components\Database\Builders;

    use Gem\Components\Database\Helpers\Pagination;
    use Gem\Components\Debug\Debug;
    use mysqli_stmt;
    use PDO;
    use PDOStatement;

    class BuildManager
    {
        use Debug;
        /**
         * @var \PDO
         */
        protected $connection;
        private $query;
        private $page;
        private $params = [];

        /**
         * Base Ataması yapar
         *
         * @param Base $base
         */
        public function __construct($base)
        {

            $this->connection = $base;
            $this->debugBoot();
        }

        /**
         * Sayfalama olayı için şuan bulunulan sayfayı atar
         *
         * @param $page
         * @return $this
         */
        public function setPage($page)
        {
            $this->page = $page;

            return $this;
        }

        /**
         * Query Sorgusunu atar
         *
         * @param string $query
         */
        public function setQuery($query)
        {

            $this->query = $query;
        }

        /**
         * parametreleri atar
         *
         * @param array $params
         */
        public function setParams($params = [])
        {

            $this->params = $params;
        }

        /**
         * Sorguyu Oluşturur
         *
         * @return PDOStatement
         */
        public function run($query = false)
        {

            $add = [
               'query'  => $this->query,
               'params' => $this->params
            ];

            if (true === $query) {
                $query = $this->connection->query($this->query);
                $add['response'] = $query;
                $this->addToDatabase($add);
                return $query;
            } else {
                $prepare = $this->connection->prepare($this->query);
                $add['response'] = $prepare;
            }
            if ($prepare instanceof PDOStatement) {
                $prepare->execute($this->params);
            } elseif ($prepare instanceof mysqli_stmt) {

                $s = "";
                foreach ($this->params as $param) {

                    if (is_string($param)) {
                        $s .= "s";
                    } elseif (is_integer($param)) {
                        $s .= "i";
                    }
                }

                if (count($this->params) < 1) {
                    $param_arr = [];
                } else {
                    $param_arr = array_merge([$s], $this->params);
                }

                call_user_func_array([$prepare, 'bind_param'], $this->refValues($param_arr));
                $prepare->execute();

            }

            $add['response'] = $prepare;
            $this->addToDatabase($add);
            return $prepare;
        }

        private function refValues($arr)
        {
            if (strnatcmp(phpversion(), '5.3') >= 0) //Reference is required for PHP 5.3+
            {
                $refs = [];
                foreach ($arr as $key => $value) {
                    $refs[$key] = &$arr[$key];
                }

                return $refs;
            }

            return $arr;
        }

        /**
         * Sayfalama işlemini yapar
         *  ['url' => 'asdasd/asdasd/:page', 'now' = 0]
         *
         * @param array $action
         * @return string
         */
        public function pagination($action = [], $return = true)
        {

            if (!is_array($action)) {
                $action = [
                   'url' => $action,
                   'now' => $this->page
                ];
            }
            $pagination = new Pagination();
            $pagination->setCount($this->run()->rowCount());
            $paginate = $pagination->paginate($action);
            if ($return) {

                return $paginate;
            } else {

                echo $paginate;
            }
        }

        public function fetch($fetchAll = false)
        {

            $query = $this->run();

            if ($query instanceof PDOStatement) {

                if ($fetchAll) {
                    return $query->fetchAll();
                } else {
                    return $query->fetch(PDO::FETCH_OBJ);
                }
            } elseif ($query instanceof mysqli_stmt) {

                $query = $query->get_result();
                if ($fetchAll) {
                    return $query->fetch_all();
                } else {
                    return $query->fetch_object();
                }
            } else {

                throw new \Exception(sprintf('Girdiğiniz veri tipi geçerli bir query değil. Tip:%s', gettype($query)));
            }
        }

        /**
         * Tüm işlemleri döndürür
         *
         * @return array|mixed|object|\stdClass
         * @throws \Exception
         */

        public function fetchAll()
        {

            return $this->fetch(true);
        }

        /**
         * Eşleşen içerik sayısını döndürür
         *
         * @return int
         */
        public function rowCount()
        {

            $query = $this->run();

            if ($query instanceof PDOStatement) {
                return $query->rowCount();
            } elseif ($query instanceof mysqli_stmt) {
                $query = $query->get_result();

                return $query->num_rows;
            }
        }
    }
