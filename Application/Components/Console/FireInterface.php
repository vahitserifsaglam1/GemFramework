<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Console;


    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Input\InputInterface;

    /**
     * Interface FireInterface
     * @package Gem\Components\Console
     */
    interface FireInterface
    {

        /**
         * Komut yakalandıktan sonra tetiklenecek fonksiyonlardan biridir
         * @param InputInterface $input
         * @param OutputInterface $output
         * @return mixed
         */
        public function fire(InputInterface $input, OutputInterface $output);
    }