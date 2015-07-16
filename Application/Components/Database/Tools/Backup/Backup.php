<?php
    /**
     *  Bu Sınıf GemFramework'de Veritabanı' nı yedeklemede kullanılır.
     *
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     */
    namespace Gem\Components\Database\Tools;

    use Gem\Components\Database\Builders\BuildManager;
    use Gem\Components\Database\Mode\Insert;
    use Gem\Components\Filesystem;

    /**
     * Class Backup
     *
     * @package Gem\Components\Database\Tools
     */
    class Backup extends BuildManager
    {


        /**
         * @param $connection Database\Base sınıfına ait bir instance
         */
        public function __construct($connection)
        {

            parent::__construct($connection);
        }

        /**
         * @param string $tables
         * @param string $name
         * @param string $src
         * @return bool
         */
        public function backup($tables = '*', $name = '', $src = DATABASE)
        {

            if ('' === $name) {
                $name = $this->generateUniq();
            }

            if ($tables === '*') {
                $tables = $this->getMysqlTables();
            } elseif (is_string($tables)) {
                $tables = explode(',', $tables);
            }

            $content = null;
            $generateArray = [];

            foreach ($tables as $table) {

                $content .= sprintf('DROP TABLE %s', $table);
                $this->setQuery(sprintf('SHOW CREATE TABLE %s', $table));
                $fetch = (array)$this->fetch();
                $this->setQuery(sprintf('SELECT * FROM %s', $table));
                $fetchTable = (array)$this->fetch();
                $generateArray[] = [
                    'createTable' => $fetch['Create Table'],
                    'params' => $fetchTable,
                    'content' => $content,
                    'table' => $fetch['Table']
                ];
            }

            $content = json_encode($generateArray);
            $fileName = sprintf('%s%s%s%s', DATABASE, 'Backup/', $name, ".php");

            $file = Filesystem::getInstance();
            if (!$file->exists($fileName)) {
                $file->touch($fileName);
                return $file->write($fileName, $content);
            } else {
                return false;
            }
        }

        /**
         * Benzersiz bir anahtar oluşturur
         *
         * @return string
         */
        private function generateUniq()
        {
            $uniq = uniqid('GemFramework');
            $uniq = md5($uniq);
            return substr($uniq, rand(0, 4), rand(4, 6));
        }

        /**
         * Tüm tabloları döndürür
         *
         * @return array
         */
        private function getMysqlTables()
        {

            $this->setQuery("SHOW TABLES");
            $fetchAll = $this->fetchAll();
            $tables = [];
            foreach ($fetchAll as $table) {
                $tables[] = $table[0];
            }

            return $tables;
        }
    }