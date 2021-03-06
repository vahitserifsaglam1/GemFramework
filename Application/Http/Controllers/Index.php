<?php
    /**
     *  Bu sınıf GemFramework'un örnek bir controller dosyasıdır.
     *
     * @packpage Gem\Controllers
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     */

    namespace Gem\Controllers;

    use Gem\Components\Database\Base;
    use Gem\Components\Database\Tools\Backup\Backup;
    use Gem\Components\Database\Tools\TablePrint;
    use Gem\Components\MemCache\MemCache;
    use Gem\Components\Redis;
    use Gem\Components\Route\Controller;
    use Gem\Components\View;
    use Gem\Components\Database\Tools\Backup\Load;

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

            // Application/Http/Views/index.php
            return view('index');
        }
    }
