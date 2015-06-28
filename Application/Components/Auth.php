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
use Gem\Components\Database\Mode\Insert;
use Gem\Components\Http\UserManager;
use Gem\Components\Session;
use Gem\Components\Facade\Cookie;
use InvalidArgumentException;

class Auth extends SchemaBag
{

    private $db;
    private $tables;

    public function __construct()
    {

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
    public function login($username, $password, $remember = false)
    {

        $loginParams = $this->tables['login'];
        $userParam = $loginParams[0];
        $passParam = $loginParams[1];
        $tableName = $this->tables['table'];
        $getTables = $this->tables['column'];
        $role = $this->tables['access'];
        $getTables = array_merge($getTables, $role);
        $login = $this->db->read($tableName, function (Read $mode) use ($getTables, $userParam, $passParam, $username, $password) {

            return $mode->where([
                [$userParam, '=', $username],
                [$passParam, '=', $password]
            ])->select($getTables)->build();

        });

        if ($login->rowCount()) {

            $fetch = $login->fetch();

            Session::set(UserManager::LOGIN, $fetch);
            if ($remember) {

                Cookie::set('login', serialize($fetch));

            }

            return $fetch;

        }

    }

    /**
     * Girilen parametrelere göre kayıt işlemi yapılır
     * @param array $input bu değer user.yaml dosyasındaki değerlerle aynı değerleri içermelidir
     * @return bool
     */
    public function register(array $input = [])
    {
        $registerParams = $this->tables['register'];
        $tableName = $this->tables['table'];

        if (count($registerParams) === count($input)) {
            $inputValues = array_values($input);
            if (count(array_diff($inputValues, $registerParams)) > 0) {
                throw new InvalidArgumentException('Register parametreleriniz user.yaml dosyasındakilerle aynı olmalıdır.');

            } else {

                $insert = $this->db->insert($tableName, function (Insert $mode) use ($input) {
                    $mode->set($input)
                         ->run();
                });

                return ($insert) ? true:false;

            }

        } else {
            throw new InvalidArgumentException('Register parametreleriniz user.yaml dosyasındakilerle aynı olmalıdır.');
        }
    }

    /**
     * Giriş yapılıp yapılmadığını kontrol eder
     * @return bool
     */
    public function isLogined()
    {

        if (Session::has(UserManager::LOGIN) || Cookie::has(UserManager::LOGIN)) {

            return true;

        }
    }
}
