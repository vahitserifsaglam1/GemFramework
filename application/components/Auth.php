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

use Gem\Components\Database\Model;
use Gem\Components\Database\Mode\Read;
use PDO;
use Gem\Components\Session;
use Gem\Components\Cookie;
use Gem\Components\Http\UserManager;

class Auth extends Model
{

    /**
     *
     * Username ve password ile kullanıcı girişi yapar
     * @param string $name
     * @param string $password
     * @param boolean $remember
     * @return boolean
     */
    public static function login($name, $password, $remember = false)
    {

        $login = self::read('user', function (Read $mode) use ($name, $password) {

            return $mode->where([

                ['username', '=', $name],
                ['password', '=', $password]
            ])->select('username.password.role')->run();
        });

        if ($login) {

            if ($login->rowCount()) {

                $fetch = $login->fetch(PDO::FETCH_OBJ);
                if (isset($fetch->role)) {

                    if ($fetch->role == '')
                        $role = 'all';
                    else

                        $role = @unserialize($fetch->role);
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
    public function setRole($username, array $role = [])
    {

        $role = serialize($role);
        $check = self::read('user', function (Read $mode) use ($username) {
            return $mode->where(['username', '=', $username])
                ->run();
        });

        if ($check->rowCount()) {

            $set = self::update('user', function ($mode) use ($username, $role) {

                return $mode->where(['username', '=', $username])
                    ->set([
                        'role' => $role
                    ])
                    ->run();
            });

            if ($set) {

                return true;

            } else {

                return false;

            }
        } else {

            return false;
        }
    }

    /**
     * Kullanıcı girişi yapılmışmı diye kontrol eder
     * @param boolean $remember
     * @return boolean
     */
    public function check($remember = false)
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


}
