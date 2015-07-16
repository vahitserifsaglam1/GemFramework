<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Console;


    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Input\InputInterface;

    /**
     * Interface HandleInterface
     * @package Gem\Components\Console
     */
    interface HandleInterface
    {
        /**
         * Komut yakalandığı zaman tetiklenecek fonksiyonlardan biridir
         * @param InputInterface $input
         * @param OutputInterface $output
         * @return mixed
         */
        public function handle(InputInterface $input, OutputInterface $output);
    }