<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Console;

    use Gem\Components\Helpers\Config;
    use Exception;

    class ConsoleArgsParser extends CommandsManager
    {

        use Config;

        /**
         * @param array $args
         * @throws Exception
         * @return array
         */
        protected static function parse(array $args = [])
        {
            $configs = self::getConfigStatic('console');
            $delimeter = $configs['delimeter'];

            if ('' === $delimeter || null === $delimeter || false === is_string($delimeter)) {
                throw new Exception('Delimeter olarak geçerli bir değer girmediniz');
            }

            $first = $args[0];
            unset($args[0]);
            if (strstr($first, $delimeter)) {
                $first = explode($delimeter, $first);
            } else {
                $first = (array)$first;
            }

            $args = array_merge($first, $args);
            list($method, $bundler) = $args;

            unset($args[0]);
            unset($args[1]);
            unset($args[2]);

            $argsnew = $args;
            if (count($args) > 0) {
                $argsnew = [];

                foreach ($args as $arg => $value) {
                    $argsnew[] = $value;
                }
            }
            return [
                'method' => $method,
                'bundle' => $bundler,
                'args' => $argsnew
            ];

        }

    }