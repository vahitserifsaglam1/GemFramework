<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Database\Tools\Migration;

    use Exception;

    class Schema
    {

        /**
         * @var \PDO|\mysqli|null
         */
        private $connection;

        /**
         * @var Table
         */
        private $table;

        /**
         * @param null $connection
         */
        public function __construct($connection = null)
        {
            $this->table = new Table();
            $this->connection = $connection;
        }

        /**
         * Tablo oluşturur ve işler
         * @param string $tableName
         * @param callable $callback
         * @return bool|\mysqli_result|\PDOStatement
         * @throws Exception
         */
        public function create($tableName = '', callable $callback)
        {
            $table = $this->table;
            $table->create($tableName);

            // çağrı yapılıyor
            $response = $callback($table);

            if ($response instanceof TableInterface) {
                $string = $response->fetch();
                return $this->connection->query($string);

            } else {
                throw new Exception('%s %s den dönen veri bir TableInterface değil', __CLASS__, __FUNCTION__);
            }
        }

        /**
         * $tableName'e girilen tabloyu siler
         *
         * @param string $tableName
         * @return bool|\mysqli_result|\PDOStatement
         */
        public function drop($tableName = '')
        {
            $query = $this->table->drop($tableName);
            return $this->connection->query($query);

        }

    }