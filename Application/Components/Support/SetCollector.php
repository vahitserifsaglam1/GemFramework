<?php

    /**
     *  Bu Trait __set fonksiyonu ile ilgili işlemler yapılması için yazılmıştır
     */

    namespace Gem\Components\Support;

    /**
     * Trait SetCollector
     *
     * @package Gem\Components\Support
     */
    trait SetCollector
    {
        private $setCollections;

        /**
         * Veriyi işler
         *
         * @param string $name
         * @param null   $value
         * @return $this
         */
        public function __set($name = '', $value = null)
        {
            $this->setCollections[$name] = $value;

            return $this;
        }

        /**
         * Verileri değiştirir
         *
         * @param array $collections
         * @return $this
         */
        public function setCollections(array $collections = [])
        {
            $this->setCollections = $collections;

            return $this;
        }

        /**
         * Toplanan verileri döndürür
         *
         * @return mixed
         */
        public function getCollectedParameters()
        {
            return $this->setCollections;
        }
    }