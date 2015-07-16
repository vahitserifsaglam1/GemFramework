<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Console;

    use Gem\Components\Application;
    use Symfony\Component\Console\Application as SymfonyConsole;
    use Symfony\Component\Console\Output\BufferedOutput;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Input\ArrayInput;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Input\InputOption;

    class Console extends SymfonyConsole
    {

        /**
         * @var BufferedOutput
         */
        private $lastOutput;
        /**
         * @var int
         */
        private $version;

        /**
         * Sınıfı başlatır ve bazı atamaları gerçekleştirir
         * @param Application $app
         * @param int $version
         */
        public function __construct($version = 1)
        {

            $this->version = $version;
            $this->setAutoExit(false);
            $this->setCatchExceptions(false);
            parent::__construct('GemFrameworkConsole', $version);
            $this->addCommandsToParent(new GetCommands());
        }

        /**
         * Tüm Komutları sınıfa ekler
         * @param GetCommands $commands
         */
        public function addCommandsToParent(GetCommands $commands)
        {


            foreach ($commands->getCommands() as $command) {
                $command = new $command();
                $this->addToParent($command);
            }

        }


        /**
         * Komutu yürütür
         * @param $command
         * @param array $params
         * @return int
         * @throws \Exception
         */
        public function call($command, array $params = [])
        {
            $params['commands'] = $params;
            $this->lastOutput = new BufferedOutput();
            return $this->find($command)->run(new ArrayInput($params), $this->lastOutput);
        }

        /**
         * Girilen Komutu sınıfa ekler
         * @param Command $command
         */
        public function addToParent(Command $command)
        {
            $this->add($command);
        }

        /**
         * Çıktıyı döndürür
         * @return string
         */
        public function output()
        {
            return isset($this->lastOutput) ? $this->lastOutput->fetch() : '';
        }

        /**
         * Get the default input definitions for the applications.
         *
         * This is used to add the --env option to every available command.
         *
         * @return \Symfony\Component\Console\Input\InputDefinition
         */
        protected function getDefaultInputDefinition()
        {
            $definition = parent::getDefaultInputDefinition();
            $definition->addOption($this->getEnvironmentOption());
            return $definition;
        }

        /**
         * Get the global environment option for the definition.
         *
         * @return \Symfony\Component\Console\Input\InputOption
         */
        protected function getEnvironmentOption()
        {
            $message = 'The environment the command should run under.';
            return new InputOption('--env', null, InputOption::VALUE_OPTIONAL, $message);
        }
    }