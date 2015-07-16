<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Database\Tools;

    use Exception;

    class Schema
    {

        private $connection;

        public function create($tableName = '', callable $callback)
        {
            $table = new Table();
            $table->create($tableName);

            // çağrı yapılıyor
            $response = $callback($table);

            if ($response instanceof TableInterface) {
                $string = $response->fetch();

            } else {
                throw new Exception('%s %s den dönen veri bir TableInterface değil', __CLASS__, __FUNCTION__);
            }
        }

    }