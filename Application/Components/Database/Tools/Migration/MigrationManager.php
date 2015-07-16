<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Database\Tools\Migration;

    use Gem\Components\Database\Base;
    use Gem\Components\Helpers\Config;
    use Gem\Components\Patterns\Singleton;
    use Exception;

    class MigrationManager
    {
        /**
         * @var \PDO|\mysqli
         */
        /**
         * @var Base
         */
        private $base;


        /**
         * Uygulamayı alır ve toplamaya başlar
         */
        public function __construct()
        {
            $this->base = new Base();
            Singleton::make('Gem\Components\Database\Tools', [$this->base->getConnection()]);
        }

        /**
         * Migration sınıfını yürütür
         * @param null $name
         */
        public function run($name = null)
        {
            $list = Config::get('app.migration.list');

            if (null !== $name) {
                if (is_array($list) && isset($list[$name])) {
                    $return = [$this->execute($name)];
                } else {
                    $return = [false];
                }
            } else {

                if (is_array($list) && count($list)) {
                    foreach ($list as $l) {
                        $return[] = $this->execute($l);
                    }
                }
            }
        }

        /**
         * @param string $name
         * @throws Exception
         * @return bool
         */
        public function execute($name = '')
        {
            $migration = "Gem\Database\Migrations\\$name";
            $migration = new $migration;

            $return = [
                'up' => null,
                'down' => null
            ];

            if ($migration instanceof MigrationInterface) {
                $return['up'] = $migration->up();
                $return['down'] = $migration->down();
            } else {
                throw new Exception('migration sınıfınız MigrationInterface e sahip değil');
            }
        }

    }