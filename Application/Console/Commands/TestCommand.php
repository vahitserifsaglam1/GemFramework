<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Console\Commands;

    use Gem\Components\Console\Command;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Input\InputInterface;

    class TestCommand extends Command
    {

        /**
         * Konsol İmzası
         *
         * @var string
         */
        protected $signature = 'test';

        /**
         * Komut açıklaması
         *
         * @var string
         */
        protected $description = 'Test Komutu';

        /**
         * Komut adı
         *
         * @var string
         */
        protected $name = 'test';


        /**
         * @param InputInterface $input
         * @param OutputInterface $output
         */

        public function handle(InputInterface $input, OutputInterface $output)
        {

        }
    }