<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Console;

    use Gem\Console\System;

    /**
     * Class CommandsManager
     * @package Gem\Components\Console
     */
    class CommandsManager extends System
    {

        /**
         * @var array
         */
        private $commands;

        /**
         * @param array $commands
         */
        public function __construct(array $commands = [])
        {
            $this->setCommands($commands);
        }

        /**
         * @param array $commands
         * @return $this
         */
        public function setCommands(array $commands)
        {
            $this->commands = $commands;
            return $this;
        }

        /**
         * @return array
         */
        protected function getCommands()
        {

            return $this->commands;
        }


        /**
         * @return string
         */
        protected function getBundlePrefix()
        {
            return $this->bundlePrefix;
        }

    }