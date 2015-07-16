<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Console\Commands;

    use Gem\Components\Console\Command;
    use Gem\Components\Filesystem;
    use Gem\Components\Support\Migrate;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Input\InputInterface;

    class MakeMvc extends Command
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

        /**
         * İçeriği oluşturur
         * @param $filepath
         * @param array $params
         * @return string
         */
        private function migrate($filepath, $params = [])
        {
            return Migrate::make($filepath, $params);
        }

        private function create($src, $fileName = '', $content = '')
        {
            $file = Filesystem::getInstance();
            $path = $src . $fileName . '.php';


            // kaynak dosya yoksa oluşturuyoruz
            if (!$file->exists($src)) {
                $file->mkdir($src);
            }

            // eğer dosya yoksa oluşturuyoruz
            if (!$file->exists($path)) {
                $file->touch($path);
                $file->write($path, $content);
            }

            $this->info(sprintf('%s isimli işlem %s yolunda başarıyla oluşturuldu.', $fileName, $src));
        }

        /**
         * Kontorller oluşturur
         * @param string $name
         */
        public function controller($name = '')
        {
            $content = $this->migrate('stroge/create/controller.php.dist', [
                'name' => $name,
            ]);

            $this->create(CONTROLLER, $name, $content);
        }

        /**
         * Kontorller oluşturur
         * @param string $name
         */
        public function model($name = '')
        {
            $table = mb_convert_case($name, MB_CASE_LOWER);
            $content = $this->migrate('stroge/create/model.php.dist', [
                'name' => $name,
                'table' => $table
            ]);

            $this->create(MODEL, $name, $content);
        }

        /**
         * Kontorller oluşturur
         * @param string $name
         */
        public function view($name = '')
        {
            $name = mb_convert_case($name, MB_CASE_LOWER, 'utf-8');
            $content = $this->migrate('stroge/create/view.php.dist', []);
            $this->create(VIEW, $name, $content);
        }


        /**
         * MVC nin tüm dosyalarını oluşturur
         * @param string $name
         */
        public function all($name = '')
        {
            $this->model($name);
            $this->view($name);
            $this->controller($name);
        }

        /**
         * Örnek Röta dosyası oluştur
         * @param string $name
         */

        public function route($name = '')
        {
            $content = $this->migrate('stroge/create/route.php.dist', [
                'name' => $name
            ]);

            $this->create(ROUTE, $name, $content);
        }
    }