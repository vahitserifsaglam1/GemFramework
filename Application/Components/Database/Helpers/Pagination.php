<?php

    /**
     *  Gem Framework Pagination sınıfı -> Sayfalama İşlemlerinde Kullanılır
     *
     * @package Gem\Components\Database\Helpers
     * @copyright (c) 2015, MyfcYazilim
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @version 1.0
     */

    namespace Gem\Components\Database\Helpers;

    use Gem\Components\Helpers\Config;
    use Gem\Components\Helpers\String\Builder;

    /**
     * Class Pagination
     * @package Gem\Components\Database\Helpers
     */
    class Pagination
    {

        use Builder,
            Config;

        private $options;
        private $count;

        public function __construct()
        {

            $this->options = $this->getConfig('db.pagination');
        }

        /**
         * Toplam içerik sayısının atar
         * @param $count
         * @return $this
         */
        public function setCount($count)
        {

            $this->count = $count;

            return $this;
        }

        /**
         * <a nın yapısını oluişturur
         * @param $i
         * @param $url
         * @param $search
         * @return string
         */
        private function chieldString($i, $url, $search)
        {

            $url = $this->replaceString($search, $i, $url);

            return "\n <a class='{$this->options['chieldClass']}' href='$url'>$i</a>";
        }

        /**
         * Sayfalama işlemini tamamlar
         * @param $action
         * @return string
         */
        public function paginate($action)
        {
            $url = $this->clearLastSlash($action['url']);

            $count = $this->count;

            $any = preg_match("/:(\w+)/", $url, $finded);
            if (!$any) {

                $url .= "/:page";
                $search = ":page";
            } else {

                $search = $finded[0];
            }
            if (isset($action['now'])) {
                $now = $action['now'];
            } else {
                $now = 1;
            }

            $s = "<div class='{$this->options['parentClass']}'>";

            if ($count < $this->options['limit']) {
                $limit = 1;
            } else {

                $limit = ceil($count / $this->options['limit']);
            }
            for ($i = $now; $i <= $limit; $i++) {

                $s .= $this->chieldString($i, $url, $search);
            }

            $s .= "\n</div>";

            return $s;
        }
    }
