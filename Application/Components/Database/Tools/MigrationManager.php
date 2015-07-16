<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Database\Tools;

    use Gem\Components\Database\Base;

    class MigrationManager
    {
        /**
         * @var \PDO|\mysqli
         */
        private $connection;
        /**
         * @var Base
         */
        private $base;


        public function __construct()
        {
            $this->base = new Base();
            $this->connection = $this->base->getConnection();
        }

    }