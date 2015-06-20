<?php
/**
 * Created by PhpStorm.
 * User: vserifsaglam
 * Date: 19.6.2015
 * Time: 04:21
 */

namespace Gem\Components;

use Gem\Components\Helpers\Server;
use Gem\Components\Crypt;
use Gem\Components\Session;

class Security extends Crypt
{

    use Server;

    const SESSION_KEY = '_CRSF_PROTECTION';

    const SESSION_RANDOMIZER_KEY = '_CRSF_RANDOMIZER_KEY';

    const AYRAC = ',';

    private $ip;

    public function __consturct()
    {
        $this->ip = $this->getIP();
    }

    public function csrf_active()
    {

        $rand = md5(rand(1567, 999999999));
        $random = $this->encode(base64_encode($rand));
        $message = $this->encode($this->ip) . self::AYRAC . $random;
        $crypted = $this->encode(base64_encode($message));
        Session::set(self::SESSION_KEY, $message);
        Session::set(self::SESSION_RANDOMIZER_KEY, $random);

        return $message;

    }

    public function csrf_deactive(){

        $random = base64_decode($this->decode(Session::get(self::SESSION_RANDOMIZER_KEY)));
        $message = base64_decode($this->decode(Session::get(self::SESSION_KEY)));

        $post = Assets::clear($_POST);

        list($code , $rand) = explode(self::AYRAC, $message);

        if($rand ===  $random && isset($code) && is_string($code) && isset($post[self::SESSION_KEY]) ){
            if($post[self::SESSION_KEY] == $code){

                return true;

            }


        }else{

            return false;

        }


    }
}