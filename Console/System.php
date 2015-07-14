<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Console;

    /**
     * Class System
     * @package Gem\Console
     */
    abstract class System
    {

        /**
         * Bu Kısıma eklediğiniz sınıflar birer komut olarak algılanacaktır
         * @var array
         */
        protected $commands = [
            'Gem\Console\Commands\TestCommand'
        ];


    }