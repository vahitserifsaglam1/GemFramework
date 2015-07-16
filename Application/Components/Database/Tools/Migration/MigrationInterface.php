<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Database\Tools\Migration;

    /**
     * Interface MigrationInterface
     * @package Gem\Components\Database\Tools\Migration
     */
    interface MigrationInterface
    {
        public function up();

        public function down();
    }