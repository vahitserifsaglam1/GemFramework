<?php

    /**
     *  Bu interface GemFramework 'Route Manager ve response arasındaki ilişikiyi sağlamakta kullanılır

     */
    namespace Gem\Components\Http\Response;

    /**
     * Interface ShouldBeResponse
     *
     * @package Gem\Components\Http\Response
     */
    interface ShouldBeResponse
    {
        /**
         *
         * @return mixed
         */
        public function execute();
    }
