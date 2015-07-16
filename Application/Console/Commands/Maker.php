<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Console\Commands;

    use Gem\Components\Console\Command;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Input\InputInterface;

    class Maker extends Command
    {

        /**
         * Konsol İmzası
         *
         * @var string
         */
        protected $signature = 'make:mvc { type? } { name? }';

        /**
         * Komut açıklaması
         *
         * @var string
         */
        protected $description = 'İçerik ve bazı şeyler oluşturur';

        /**
         * Komut adı
         *
         * @var string
         */
        protected $name;

        /**
         * @param InputInterface $input
         * @param OutputInterface $output
         */

        public function handle(InputInterface $input, OutputInterface $output)
        {
            $type = $this->argument('type');
            if ($this->argument('name')) {
                $name = $this->argument('name');
            } else {
                $name = 'Index';
            }

            if (is_callable([$this, $type])) {
                $this->$type($name);
            } else {
                $this->error(sprintf('%s adında bir olay bulunamadı', $type));
            }

        }
    }