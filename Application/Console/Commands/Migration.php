<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Console\Commands;


    use Gem\Components\Console\Command;
    use Gem\Components\Console\HandleInterface;
    use Gem\Components\Database\Tools\Migration\MigrationManager;
    use Gem\Components\Filesystem;
    use Gem\Components\Support\Migrate;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Input\InputInterface;

    class Migration extends Command implements HandleInterface
    {

        /**
         * Komut İmzası
         *
         * @var string
         */
        protected $signature = 'make:migration { function? } { name? }';

        /**
         * Komut Açıklaması
         *
         * @var string
         */
        protected $description = 'Migration oluşturma ve düzenleme komutları';

        /**
         * @var MigrationManager
         */
        protected $manager;

        /**
         * @var Filesystem
         */
        protected $file;

        public function handle(InputInterface $input, OutputInterface $output)
        {
            $this->file = Filesystem::getInstance();
            $this->manager = new MigrationManager();
            $command = $this->argument('function') ? $this->argument('function') : 'create';
            $param = $this->argument('name') ? $this->argument('name') : '';
            if (is_callable([$this, $command])) {
                $this->$command($param);
            } else {
                $this->error('%s adında bir komut bulunamadı', $command);
            }

        }

        /**
         * İÇeriği dosyaya yazar
         * @param $src
         * @param $fileName
         * @param $content
         * @throws \Exception
         */
        private function write($src, $fileName, $content)
        {
            if (!$this->file->exists($src)) {
                $this->file->mkdir($src);
            }
            $this->file->chmod($src, 0777);

            if ($this->file->isWriteable($fileName)) {
                $this->file->write($fileName, $content);
                $this->info(sprintf('%s isimli migration dosyası %s yolunda başarıyla yazıldı', $fileName, $src));
            } else {
                $this->error(sprintf('%s isimli dosya %s yoluna yazılamadı, sebep: dosya yazılabilir değil', $fileName,
                    $src));
            }
        }


        /**
         * Dosyayı silmeye yarar
         * @param string $name
         */
        public function forget($name = '')
        {
            $filePath = $this->manager->createName($name);

            if ($this->file->exists($filePath)) {
                $this->file->delete($filePath);
                $this->info(sprintf('%s isimli migration dosyanız %s yolundan silinmiştir', $name, $filePath));
            } else {
                $this->error(sprintf('%s isimli migration dosyanız %s yolundan silenemedi, dosya mevcut değil', $name,
                    $filePath));
            }

        }

        /**
         * Fonksiyonu yürütür
         * @param string $name
         */
        public function deploy($name = '')
        {
            $response = $this->manager->run($name);

            foreach ($response as $answer) {
                $up = $answer['up'];
                $down = $answer['down'];
                $fname = $answer['name'];

                if (null !== $up) {
                    if (false !== $up) {
                        $this->info(sprintf('%s dosyasında up fonksiyonu başarılı bir şekilde çalıştı', $fname));
                    } else {
                        $this->error(sprintf('%s dosyasında up fonksiyonu hatalı bir şekilde çalıştı', $fname));

                    }
                }

                // düşürme işlemi
                if (null !== $down) {
                    if (false !== $down) {
                        $this->info(sprintf('%s dosyasında down fonksiyonu başarılı bir şekilde çalıştı', $fname));
                    } else {
                        $this->error(sprintf('%s dosyasında down fonksiyonu hatalı bir şekilde çalıştı', $fname));

                    }
                }
            }

        }

        /**
         * @param string $name
         */
        private function create($name = '')
        {
            $content = $this->migrate('stroge/create/migration.php.dist', ['name' => $name]);
            $fileName = $this->manager->createName($name);
            if (!$this->file->exists($fileName)) {
                $this->file->touch($fileName);
                $this->write(DATABASE . 'Migrations/', $fileName, $content);
            } else {
                $this->error(sprintf('%s isimli dosya zaten %s yolunda var', $name, $fileName));
            }
        }

        /**
         * Migration içeriğini oluşturur
         * @param $name
         * @param array $params
         * @return string
         */
        private function migrate($name, $params = [])
        {
            return Migrate::make($name, $params);
        }

    }