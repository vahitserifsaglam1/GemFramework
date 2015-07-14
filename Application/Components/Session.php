<?php

    /**
     *  Gem Framework Session Sınıfı, session'a atama yapmakda kullanılır.
     *
     * @package Gem\Components
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     */

    namespace Gem\Components;

    use Gem\Components\Session\SecureSessionHandler;
    use Gem\Components\Support\SecurityKey;

    class Session extends SecureSessionHandler
    {

        use SecurityKey;

        public function __construct()
        {
            parent::__construct($this->keyGenerate());
        }

        /**
         * Veriyi döndürür
         *
         * @param string $name
         * @return mixed
         */
        public function get($name)
        {
            if ($this->isValid()) {
                return $this->getValue($name);
            } else {
                return false;
            }
        }

        /**
         * @param $name
         * @param $value
         * @return $this
         */
        public function set($name, $value)
        {

            if ($this->isValid()) {
                $this->setValue($name, $value);
            }

            return $this;
        }

        /**
         * Veriyi siler
         *
         * @param $name
         * @return $this
         */
        public function delete($name)
        {
            if (isset($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }

            return $this;
        }

        /**
         * Tüm oturum verilerini temilzer
         */
        public function flush()
        {
            foreach ($_SESSION as $name => $value) {
                unset($_SESSION[$name]);
            }
        }

        /**
         * İtem varmı yokmu diye kontrol eder
         *
         * @param null $name
         * @return bool
         */
        public function has($name = null)
        {
            if ($name === null) {
                return isset($_SESSION);
            } else {
                return isset($_SESSION[$name]);
            }
        }
    }
