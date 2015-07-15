<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Console;

    use Exception;

    /**
     * Class Console
     * @package Gem\Components\Console
     */
    class Console extends ConsoleArgsParser
    {

        private $argc;
        private $args;
        private $types = [
            'commands',
            'params'
        ];
        private $config;

        /**
         * @param array $args Komut elemanları
         * @param int $argc Komut sayısı
         */

        public function __construct(array $args = [], $argc = 0)
        {
            unset($args[0]);
            $args[0] = $args[1];
            $this->args = $args;
            $this->argc = $argc;
        }


        /**
         * Komutları alır, parçalar ve çıktıyı oluşturur
         * @throws Exception
         * @return bool
         */
        public function run()
        {

            if ($this->argc > 1 && is_array($this->args)) {
                list($method, $bundle, $args) = values(static::parse($this->args));
                $clean = $this->cleanParamsAndCommands($args);
                $params = $clean['params'];
                $commands = $clean['commands'];

                if (isset($params[0])) {
                    $commandClass = first($params);
                    unset($params[0]);
                }
            } else {
                throw new Exception('Parametreniz sayınız 1 den küçük olamaz');
            }
        }

        /**
         * Parametreleri temizler
         * @param array $args
         * @return array
         */

        private function cleanParamsAndCommands(array $args = [])
        {
            if (count($args) > 0) {

                $return = [];
                foreach ($args as $value) {
                    if (strstr($value, "--")) {

                        $argExplode = explode("=", $value);

                        $first = str_replace("--", "", first($argExplode));
                        $second = $argExplode[1];

                        $types = $this->types;
                        foreach ($types as $type) {

                            if ($type === $first) {
                                $return[$type][] = $second;
                            }
                        }
                    } else {

                        $return['params'][] = $value;
                    }
                }
                return $return;

            } else {
                return $args;
            }

        }

    }