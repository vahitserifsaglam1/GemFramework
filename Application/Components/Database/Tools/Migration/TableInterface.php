<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Database\Tools\Migration;


    interface TableInterface
    {
        /**
         * Timestamp ekler
         * @param string $tableName
         * @return mixed
         */
        public function timestamp($tableName = '');

        /**
         * date değeri ekler
         * @param string $tableName
         * @return $this
         */
        public function date($tableName = '');

        /**
         * time değeri ekler
         * @param string $tableName
         * @return $this
         */
        public function time($tableName = '');

        /**
         * datetime değeri ekler
         * @param string $tableName
         * @return $this
         */
        public function datetime($tableName = '');

        /**
         * text değeri ekler
         * @param string $tableName
         * @return $this
         */
        public function text($tableName = '');

        /**
         * Yapıya primary key ekler
         * @param string $id
         * @return $this
         */
        public function primary($id = 'id');

        /**
         * İnt değeri ekler
         * @param string $table
         * @param int $limit
         * @return $this
         */

        public function int($table = '', $limit = 255);


        /**
         * Varchar değeri ekler
         * @param string $table
         * @param int $limit
         * @return $this
         */
        public function varchar($table = '', $limit = 255);

        /**
         * Sınıfta kullanılacak değerlerin null olarak kullanılıp kullanılamyacağını ayarlar
         * @param string $null
         * @return $this
         */
        public function null($null = 'NOT NULL');

    }