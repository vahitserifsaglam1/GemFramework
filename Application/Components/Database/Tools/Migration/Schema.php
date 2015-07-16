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
         * @param null $connection
         */
        public function __construct($connection = null)
        {
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
            $table = new Table();
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

    }