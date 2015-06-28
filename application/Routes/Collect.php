<?php
/**
 *
 *  Bu sınıf ta __construct() fonksiyonun içinde Rötalarınızı toplayabilirsiniz
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 *
 */
namespace Gem\Routes;
use Gem\Components\Facade\Route;
/**
 * Class Collect
 * @package Gem\Routes
 */

class Collect {

    public function __construct()
    {

        Route::get('/', 'pages.home');

    }

}