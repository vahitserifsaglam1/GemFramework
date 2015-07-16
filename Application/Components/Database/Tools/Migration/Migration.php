<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Database\Tools\Migration;

    /**
     * Class Migration
     * @package Gem\Components\Database\Tools
     */
    class Migration
    {

        protected $name;

        /**
         * Migration'u kaydeder
         */
        public function __construct()
        {
            if (isset($this->name)) {
                Config::add('app.migration.list', $this->name);
            }
        }


    }