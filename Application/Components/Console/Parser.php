<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Console;

    use InvalidArgumentException;
    use Exception;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputOption;

    class Parser
    {

        /**
         *
         * Girilen Consol imzsasını parçalar.
         * @param string $exp
         * @return array
         * @throws Exception
         */

        public static function parse($exp = '')
        {
            if (!is_string($exp)) {
                //eğer bir string ifadesi değilse istisna oluşturuyoruz
                throw new InvalidArgumentException('Parçalanacak veri string olmalıdır');
            }

            if ('' === $exp) {
                // eğer boşsa istisna oluşturuyoruz
                throw new InvalidArgumentException('Konsol imzanız boş olamaz');
            }


            if (preg_match('/([^\s]+)/', $exp, $matches)) {
                $name = $matches[0];
            } else {
                throw new Exception('%s metninde herhangi bir isim bulunamadı', $exp);
            }

            preg_match_all('/\{\s*(.*?)\s*\}/', $exp, $matches);

            $items = isset($matches[1]) ? $matches[1] : [];

            if (count($items) > 0) {
                return array_merge([$name], static::items($items));
            } else {
                return [$name, [], []];
            }
        }


        /**
         * Girilen metni arguments ve options olarak parçalar
         * @param array $items
         * @return array
         */
        protected static function items(array $items = [])
        {

            $args = [];
            $opt = [];

            foreach ($items as $item) {
                // eğer -- ile başlıyorsa option olarak algılattırdık
                if (0 !== strpos($item, "--")) {
                    $args[] = static::arg($item);
                } else {
                    $opt[] = static::opt($item);
                }
            }

            // return array
            return [$args, $opt];
        }

        /**
         * @param string $token
         * @return InputArgument
         */
        protected static function arg($token = '')
        {

            // açıklama parametresi
            $desc = '';

            if (strstr($token, ' : ')) {

                // veriyi : ile parçalıyoruz
                list($token, $desc) = explode(' : ', $token, 2);
                $token = trim($token);
                $desc = trim($desc);
            }


            switch (true) {
                case substr($token, -2) === '?*':
                    return new InputArgument(trim($token, '?*'), InputArgument::IS_ARRAY, $desc);
                    break;
                case substr($token, -2) === '?':
                    return new InputArgument(trim($token, '?'), InputArgument::OPTIONAL, $desc);
                    break;

                case substr($token, -2) === '*':
                    return new InputArgument(trim($token, '*'), InputArgument::IS_ARRAY | InputArgument::REQUIRED,
                        $desc);
                    break;
                case (preg_match('/(.+)\=(.+)/', $token, $matches)):
                    return new InputArgument($matches[1], InputArgument::OPTIONAL, $desc, $matches[2]);
                default:
                    return new InputArgument($token, InputArgument::REQUIRED, $desc);
            }
        }


        /**
         * @param string $token
         * @return InputOption
         */
        protected static function opt($token = '')
        {

            $description = null;

            if (strstr($token, ' : ')) {

                // veriyi : ile parçalıyoruz
                list($token, $desc) = explode(' : ', $token, 2);
                $token = trim($token);
                $desc = trim($desc);
            }

            $shortcut = null;

            $matches = preg_split('/\s*\|\s*/', $token, 2);
            if (isset($matches[1])) {
                $shortcut = $matches[0];
                $token = $matches[1];
            }


            switch (true) {
                case substr($token, -2) === '=':
                    return new InputOption(trim($token, '='), $shortcut, InputOption::VALUE_OPTIONAL, $description);
                case substr($token, -2) === '=*':
                    return new InputOption(trim($token, '=*'), $shortcut,
                        InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, $description);
                case (preg_match('/(.+)\=(.+)/', $token, $matches)):
                    return new InputOption($matches[1], $shortcut, InputOption::VALUE_OPTIONAL, $description,
                        $matches[2]);
                default:
                    return new InputOption($token, $shortcut, InputOption::VALUE_NONE, $description);
            }
        }
    }