<?php
    /**
     *  Bu Sınıf GemFramework'de Veritabanı' nı yedeklemede kullanılır.
     *
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     */
    namespace Gem\Components\Database\Tools\Backup;

    use Gem\Components\Database\Base;
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
         * @param Base $connection Database\Base sınıfına ait bir instance
         */
        public function __construct(Base $connection)
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

            $generateArray = [];

            foreach ($tables as $table) {
                $content = sprintf('DROP TABLE IF EXISTS `%s`', $table);
                $this->setQuery(sprintf('SHOW CREATE TABLE `%s`', $table));
                $fetch = (array)$this->fetch(true)[0];
                $this->setQuery(sprintf('SELECT * FROM %s', $table));
                if ($fetchTable = $this->fetch()) {
                    $fetchTable = (array)$fetchTable;
                    $generateArray[] = [
                        'createTable' => $fetch['Create Table'],
                        'params' => $fetchTable,
                        'content' => $content,
                        'table' => $table
                    ];
                }
            }

            if (count($generateArray)) {
                $backupPath = DATABASE . 'Backup/';

                $content = json_encode($generateArray);
                $fileName = sprintf('%s%s%s', $backupPath, $name, ".php");
                $file = Filesystem::getInstance();

                if (!$file->exists($backupPath)) {
                    $file->mkdir($backupPath);
                }

                $file->chmod($backupPath, 0777);

                if (!$file->exists($fileName)) {
                    $file->touch($fileName);
                    $file->chmod($fileName, 0777);
                    return $file->write($fileName, $content);
                } else {
                    return false;
                }
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