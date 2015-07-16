<?php
    /**
     *  Bu sınıf GemFramework'un örnek bir controller dosyasıdır.
     *
     * @packpage Gem\Controllers
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     */

    namespace Gem\Controllers;

    use Gem\Components\Database\Tools\TablePrint;
    use Gem\Components\Route\Controller;
    use Gem\Components\View;

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
         * @return View
         */

        public function open()
        {
            return view('index');
        }
    }
