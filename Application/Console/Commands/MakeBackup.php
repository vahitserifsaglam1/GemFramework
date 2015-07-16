<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Console\Commands;


    use Gem\Components\Console\Command;
    use Gem\Components\Console\HandleInterface;
    use Gem\Components\Database\Base;
    use Gem\Components\Database\Tools\Backup\Backup;
    use Gem\Components\Database\Tools\Backup\Load;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Input\InputInterface;

    class MakeBackup extends Command implements HandleInterface
    {

        /**
         * Komut İmzası
         *
         * @var string
         */

        protected $signature = 'make:backup { function? } { params? }';


        /**
         * Komut açıklaması
         *
         * @var string
         */
        protected $description = 'Veritabanında yedekleme ve yükleme işlemleri için kullanılır';


        /**
         * Komut adı
         *
         * @var
         */
        protected $name;


        /**
         * Backup loader sınıfı
         *
         * @var Load
         */
        private $load;

        /**
         * Backup sınıfı
         *
         * @var Backup
         */

        private $backup;

        /**
         * Veritabanı sınıfı
         *
         * @var Base
         */
        private $base;

        /**
         * Komutun yakalndığı zaman tetikleneceği fonksiyon
         *
         * @param InputInterface $input
         * @param OutputInterface $output
         * @return mixed
         */
        public function handle(InputInterface $input, OutputInterface $output)
        {
            $this->base = new Base();
            $this->load = new Load($this->base);
            $this->backup = new Backup($this->base->getConnection());

            $command = $this->argument('function') ? $this->argument('function') : 'create';
            $param = $this->argument('params') ? $this->argument('params') : '';

            if (is_callable([$this, $command])) {
                $this->$command($param);
            } else {
                $this->error('%s adında bir komut bulunamadı', $command);
            }
        }
    }