<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Console\Commands;

    use Gem\Components\Console\Command;
    use Gem\Components\Console\HandleInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Input\InputInterface;

    class Migration extends Command implements HandleInterface
    {

        /**
         * Komut İmzası
         *
         * @var string
         */
        protected $signature = 'migration { islem? } { name? }';

        protected $commands = [
            'create' => 'create %s',
            'initall' => 'migrate -e development',
            'init' => 'migrate -e development %s',
        ];
        /**
         * Komut açıklaması
         *
         * @var string
         */
        protected $description = 'migartion oluşturucu';

        /**
         * Komut ismi
         *
         * @var
         */
        protected $name;


        private function getMigrationCommand($islem = '', $name = '')
        {
            if (isset($this->commands[$islem])) {

                $command = $this->commands[$islem];

                if (strstr($command, "%s")) {
                    $command = sprintf($command, $name);
                }
                return $command;
            } else {
                $this->error(sprintf('%s adında bir komut bulunamadı'));
            }
        }

        public function handle(InputInterface $input, OutputInterface $output)
        {

            $islem = $this->argument('islem') ? $this->argument('islem') : 'create';
            $name = $this->argument('name') ? $this->argument('name') : 'GemNewMigration';

            $command = $this->getMigrationCommand($islem, $name);
            $this->info('İşleminiz yapılıyor');
            $val = shell_exec(sprintf("php vendor/bin/phinx %s", $command));
            $this->line($val);

        }
    }