<?php

/**
 *
 *  Bu sınıf GemFramework'e ait bir sınıftır.GemFrameworkde kullanıcı login işlemini tutar.
 * @author vahitserifsaglam
 * @copyright (c) 2015, vahit şerif sağlam
 * @package Gem\Components
 *
 */

namespace Gem\Components;

use Gem\Components\Facade\Database;
use Gem\Components\Database\Mode\Read;
use PDO;
use Gem\Components\Session;
use Gem\Components\Cookie;
use Gem\Components\Http\UserManager;

class Auth
{

    /**
     *
     * Username ve password ile kullanıcı girişi yapar
     * @param string $name
     * @param string $password
     * @param boolean $remember
     * @return boolean
     */
    public static function login($username, $password, $remember = false)
    {

        $login = Database::read('user', function (Read $mode) use ($username, $password) {

            return $mode->where([

                ['username', '=', $username],
                ['password', '=', $password]
            ])->select('*')->rowCount();
        });


        if ($login) {

            if ($login->rowCount()) {

                $fetch = $login->fetch(PDO::FETCH_OBJ);
                if (isset($fetch->role)) {

                    if ($fetch->role == '')
                        $role = 'all';
                    else

                        if($fetch->role !== ''){
                            $role = unserialize($fetch->role);
                        }

                }

                $username = $fetch->username;
                $array = [
                    'username' => $username,
                    'role' => $role
                ];
                Session::set(UserManager::LOGIN, $array);


                if ($remember) {

                    Cookie::set(UserManager::LOGIN, serialize($array), time() + 3600);
                }

                return $array;
            } else {

                return false;
            }
        }
    }

    /**
     * Kullanıcının sahip olduğu yetkileri atar
     * @param string $username
     * @param array $role
     */
    public static function setRole(array $role = [])
    {

        $role = serialize($role);

            if ($role) {

                $_SESSION[UserManager::LOGIN]['role'] = $role;
                return true;

            } else {

                return false;

            }

    }

    /**
     * Kullanıcı girişi yapılmışmı diye kontrol eder
     * @param boolean $remember
     * @return boolean
     */
    public static function check($remember = false)
    {

        if (Session::has(self::LOGIN)) {

            return true;

        }
        if ($remember) {

            if (Cookie::has(self::LOGIN)) {

                return true;

            }

        }

    }

    public static function logout($remember = false){

        Session::delete(UserManager::LOGIN);

        if($remember){
            Cookie::delete(UserManager::LOGIN);
        }

    }


}
