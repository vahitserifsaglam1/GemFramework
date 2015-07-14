<?php
    /**
     *  Bu sınıf GemFramework'un örnek bir controller dosyasıdır.
     *
     * @packpage Gem\Controllers
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     */

    namespace Gem\Controllers;

    use Gem\Components\Database\Base;
    use Gem\Components\Database\Mode\Read;
    use Gem\Components\Route\Controller;

    /**
     * Class IndexController
     *
     * @package Gem\Controllers
     */

    class Index extends Controller
    {
        /**
         *  Starter Function
         */
        public function __construct()
        {
            //
        }

        /**
         * Route tarafından Index::boot atandığı için bu tetiklenir.
         *
         * @return Response
         */

        public function open()
        {

            return response('hello world');
        }
    }
