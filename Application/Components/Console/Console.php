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
                print_r(static::parse($this->args));
                list($method, $bundle, $args) = values(static::parse($this->args));
                $args = array_filter($args, function ($value) {

                    if (strstr($value, "--command=")) {
                        return [
                            'command' => explode("--command=", $value)[1]
                        ];
                    } else {
                        return $value;
                    }

                });

                print_r($args);

            } else {
                throw new Exception('Parametreniz sayınız 1 den küçük olamaz');
            }
        }


    }