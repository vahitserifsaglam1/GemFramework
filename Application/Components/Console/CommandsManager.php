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
         * Yeni Komut ekler
         * @param string $command
         */
        public function addCommand($command = '')
        {
            $this->commands[] = $command;
        }

        /**
         * @return array
         */
        protected function getCommands()
        {

            return $this->commands;
        }

    }