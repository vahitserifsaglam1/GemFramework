<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Support;


    use Gem\Components\Filesystem;
    use Exception;

    class Migrate
    {

        private static $parametres;

        /**
         * İçeriği okur ve değiştirir
         * @param string $filePath
         * @param array $parametres
         * @return string
         * @throws \Exception
         */
        public static function make($filePath = '', $parametres = [])
        {
            $file = Filesystem::getInstance();
            if ($file->exists($filePath)) {
                $content = $file->read($filePath);
                // parametreleri sınıfa atadık
                static::$parametres = $parametres;

                return static::parse($content);
            } else {
                return '';
            }

        }

        /**
         * @param string $content
         * @return mixed|string
         * @throws Exception
         */
        protected static function parse($content = '')
        {


            if (!is_string($content)) {
                throw new Exception('İçeriğiniz mutlaka string olmalıdır');
            }
            $parametres = static::$parametres;

            foreach ($parametres as $key => $val) {
                $paramstring = static::getParamString($key);
                $content = str_replace($paramstring, $val, $content);
            }

            return $content;
        }

        /**
         * Değiştirilecek içeriği oluşturur
         * @param string $key
         * @return string
         */
        private static function getParamString($key = '')
        {
            if (!strstr($key, "{{") && !strstr($key, "}}")) {
                return "{{ $key }}";
            } else {
                return $key;
            }
        }

    }