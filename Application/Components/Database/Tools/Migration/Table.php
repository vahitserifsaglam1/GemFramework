<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Database\Tools\Migration;


    class Table implements TableInterface
    {
        private $patterns = [
            'create' => 'CREATE TABLE IF NOT EXISTS `%s`(',
            'auto_increment' => '`%s` INT(%d) UNSIGNED AUTO_INCREMENT PRIMARY KEY,',
            'int' => '`%s` INT(%d) %s,',
            'varchar' => '`%s` VARCHAR(%d) CHARACTER SET %s %s,',
            'timestamp' => '`%s` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,',
            'date' => '`%s` DATE %s,',
            'year' => '`%s` YEAR %s,',
            'time' => '`%s` TIME %s,',
            'datetime' => '`%s` DATETIME %s,',
            'text' => '`%s` TEXT CHARACTER SET %s %s,',
            'end' => ') DEFAULT CHARSET=%s;',
            'drop' => 'DROP TABLE `%s`;'
        ];

        private $null = 'NOT NULL';
        private $selected = [
            'patterns' => [],
            'values' => []
        ];
        private $charset = 'utf8';

        /**
         * Karekter setini ayarlar
         * @param string $charset
         * @return $this
         */
        public function charset($charset = 'utf-8')
        {
            $this->charset = $charset;
            return $this;
        }

        /**
         * @param string $tableName
         * @return $this
         */
        public function create($tableName = '')
        {
            $this->selected['patterns'][] = 'create';
            $this->selected['values']['create'] = [$tableName];
            return $this;
        }

        /**
         * timestamp değeri ekler
         * @param string $tableName
         * @return $this
         */
        public function timestamp($tableName = '')
        {
            $this->selected['patterns'][] = 'timestamp';
            $this->selected['values']['timestamp'] = [$tableName, $this->null];
            return $this;
        }

        /**
         * date değeri ekler
         * @param string $tableName
         * @return $this
         */
        public function date($tableName = '')
        {
            $this->selected['patterns'][] = 'date';
            $this->selected['values']['date'] = [$tableName, $this->null];
            return $this;
        }

        /**
         * içeriği oluşturur ve döndürür
         * @param string $tableName
         * @return string
         */
        public function drop($tableName = '')
        {
            return sprintf($this->patterns['drop'], $tableName);
        }

        /**
         * time değeri ekler
         * @param string $tableName
         * @return $this
         */
        public function time($tableName = '')
        {
            $this->selected['patterns'][] = 'time';
            $this->selected['values']['time'] = [$tableName, $this->null];
            return $this;
        }

        /**
         * datetime değeri ekler
         * @param string $tableName
         * @return $this
         */
        public function datetime($tableName = '')
        {
            $this->selected['patterns'][] = 'datetime';
            $this->selected['values']['datetime'] = [$tableName, $this->null];
            return $this;
        }


        /**
         * text değeri ekler
         * @param string $tableName
         * @return $this
         */
        public function text($tableName = '')
        {
            $this->selected['patterns'][] = 'text';
            $this->selected['values']['text'] = [$tableName, $this->charset, $this->null];
            return $this;
        }

        /**
         * Sonlandırır
         */
        public function end()
        {
            $this->selected['patterns'][] = 'end';
            $this->selected['values']['end'] = [];
            return $this;
        }

        /**
         * Yapıya primary key ekler
         * @param string $id
         * @return $this
         */
        public function primary($id = 'id')
        {
            $this->selected['patterns'][] = 'auto_increment';
            $this->selected['values']['auto_increment'] = [$id];
            return $this;
        }

        /**
         * İnt değeri ekler
         * @param string $table
         * @param int $limit
         * @return $this
         */

        public function int($table = '', $limit = 255)
        {
            $this->selected['patterns'][] = 'int';
            $this->selected['values']['int'] = [$table, $limit, $this->null];
            return $this;
        }

        /**
         * Varchar değeri ekler
         * @param string $table
         * @param int $limit
         * @return $this
         */
        public function varchar($table = '', $limit = 255)
        {
            $this->selected['patterns'][] = 'varchar';
            $this->selected['values']['varchar'] = [$table, $limit, $this->charset, $this->null];
            return $this;
        }

        /**
         * Sınıfta kullanılacak değerlerin null olarak kullanılıp kullanılamyacağını ayarlar
         * @param string $null
         * @return $this
         */
        public function null($null = 'NOT NULL')
        {
            $this->null = $null;
            return $this;
        }


        /**
         * @return mixed
         */
        public function fetch()
        {
            $string = '';
            $selected = $this->selected;
            $patterns = $this->patterns;
            foreach ($selected['patterns'] as $select) {
                if (isset($patterns[$select])) {
                    $pattern = [$patterns[$select]];
                    $values = $selected['values'][$select];
                    $vals = array_merge($pattern, $values);
                    $string .= call_user_func_array('sprintf', $vals);

                }
            }

            $string = rtrim($string, ',');
            $string .= sprintf($patterns['end'], $this->charset);

            return $string;
        }
    }