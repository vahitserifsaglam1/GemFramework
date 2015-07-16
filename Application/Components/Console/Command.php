<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Console;

    use Gem\Components\App;
    use Gem\Components\Application;
    use Symfony\Component\Console\Command\Command as SymfonyCommand;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;

    class Command extends SymfonyCommand
    {

        /**
         * Sınıfa gönderilen input objesi
         *
         * @var InputInterface
         */
        protected $input;

        /**
         * Sınıfa gönderilen output objesi
         *
         * @var OutputInterface
         */

        protected $output;

        /**
         * Açıklama yazısı
         *
         * @var string
         */
        protected $description;

        /**
         * Komutun adı ve paremetreleri toplayan yapı
         *
         * @var string
         */
        protected $signature;

        /**
         * Konsol komut ismi
         *
         * @var string
         */

        protected $name;


        /**
         * @var Application
         */
        protected $gem;

        /**
         *  Başlatıcı fonksiyon, ismi ve açıklamaların ayarlamasını yapar
         */

        public function __construct()
        {
            if (isset($this->signature)) {
                $this->registerSignature();
            } else {
                parent::__construct($this->name);
            }
            $this->setDescription($this->description);
        }

        /**
         * İsim ve parametreleri kayıt eder
         *
         */
        private function registerSignature()
        {
            list($name, $arguments, $options) = Parser::parse($this->signature);
            parent::__construct($name);
            foreach ($arguments as $argument) {
                // parametreleri ekliyoruz
                $this->getDefinition()->addArgument($argument);
            }
            foreach ($options as $option) {
                // ayarları ekliyoruz
                $this->getDefinition()->addOption($option);
            }
        }

        /**
         * Symfony Konsol Uygulamasını Yürütür
         * @param InputInterface $input
         * @param OutputInterface $output
         * @return int
         * @throws \Exception
         */
        public function run(InputInterface $input, OutputInterface $output)
        {
            $this->input = $input;
            $this->output = new OutputStyle($input, $output);

            return parent::run($input, $output);
        }

        /*
            * Argument değeri ni veya değerlerini döndürü
            *
            * @param  string  $key
            * @return string|array
            */
        public function argument($key = null)
        {
            if (is_null($key)) {
                return $this->input->getArguments();
            }
            return $this->input->getArgument($key);
        }

        /**
         * Option değerini veya değerlerini döndürür.
         *
         * @param  string $key
         * @return string|array
         */
        public function option($key = null)
        {
            if (is_null($key)) {
                return $this->input->getOptions();
            }
            return $this->input->getOption($key);
        }

        /**
         * Komutu çalıştırır
         *
         * @param  \Symfony\Component\Console\Input\InputInterface $input
         * @param  \Symfony\Component\Console\Output\OutputInterface $output
         * @return mixed
         */
        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $method = method_exists($this, 'handle') ? 'handle' : 'fire';
            return $this->getGem()->call($this, $method, [$input, $output]);
        }

        /**
         * @return Application
         */
        public function getGem()
        {
            return $this->gem;
        }

        /**
         * @param Application $app
         * @return $this
         */
        public function setGem(Application $app)
        {
            $this->gem = $app;
            return $this;
        }

        /**
         * Bilgilendirme çıktısı oluşturur
         *
         * @param  string $string
         * @return void
         */
        public function info($string)
        {
            $this->output->writeln("<info>$string</info>");
        }

        /**
         * Normal mesaj oluşturur
         *
         * @param  string $string
         * @return void
         */
        public function line($string)
        {
            $this->output->writeln($string);
        }

        /**
         * Yorum için içerik oluşturur
         *
         * @param  string $string
         * @return void
         */
        public function comment($string)
        {
            $this->output->writeln("<comment>$string</comment>");
        }

        /**
         * Soru için mesaj oluşturur
         *
         * @param  string $string
         * @return void
         */
        public function question($string)
        {
            $this->output->writeln("<question>$string</question>");
        }

        /**
         * Hata çıktısı oluşturur
         *
         * @param  string $string
         * @return void
         */
        public function error($string)
        {
            $this->output->writeln("<error>$string</error>");
        }

    }