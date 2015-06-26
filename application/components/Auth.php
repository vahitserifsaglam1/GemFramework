<?php

/**
 *
 * Bu sınıf GemFramework'e ait bir sınıftır.GemFrameworkde kullanıcı login işlemini tutar.
 * @author vahitserifsaglam
 * @copyright (c) 2015, vahit şerif sağlam
 * @package Gem\Components
 *
 */

namespace Gem\Components;

use Gem\Components\Database\Base;
use Gem\Components\Auth\SchemaBag;
use Gem\Components\Database\Mode\Read;
use Gem\Components\Http\UserManager;
use Gem\Components\Session;
use Gem\Components\Facade\Cookie;
class Auth extends SchemaBag
{

    private $db;
    private $tables;

    public function __construct(){

        $this->db = new Base();
        parent::__construct();
        $this->tables = $this->getDecodedSchema();

    }

    /**
     * $username ve $password ile user.yaml deki login değerlerine göre giriş işlemi yapar,
     * eğer $remember true girilirse cookie 'e giriş değeri atanır
     * @param $username
     * @param $password
     * @param bool $remember
     * @return mixed
     */
    public function login($username, $password, $remember = false){

        $loginParams = $this->tables['login'];
        $userParam = $loginParams[0];
        $passParam = $loginParams[1];
        $tableName = $this->tables['table'];
        $getTables = $this->tables['column'];
        $role = $this->tables['access'];
        $getTables = array_merge($getTables, $role);
        $login = $this->db->read($tableName, function(Read $mode) use ($getTables,$userParam, $passParam,$username,$password){

            return $mode->where([
                [$userParam,'=',$username],
                [$passParam,'=',$password]
            ])->select($getTables)->build();

        });

        if($login->rowCount())
        {

            $fetch = $login->fetch();

            Session::set(UserManager::LOGIN, $fetch);
            if($remember){

                Cookie::set('login', serialize($fetch));

            }

            return $fetch;

        }

    }

    /**
     * Giriş yapılıp yapılmadığını kontrol eder
     * @return bool
     */
    public function isLogined(){

        if(Session::has(UserManager::LOGIN) || Cookie::has(UserManager::LOGIN)){

            return true;

        }
    }
}
