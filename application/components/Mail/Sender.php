<?php

/**
 *
 *  Bu Sınıf GemFramework' e ait bir sınıftır, istenilirse kopyalanılıp ayrı olarak kullanılabilir.
 *
 *  Bu sınıf ile phpmailer altyapısı ile stmp üzerinden mail gönderilir.
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @copyright (c) 2015, vahit serif saglam
 * @package Gem\Components\Mail
 * @see https://github.com/PHPMailer/PHPMailer
 *
 */

namespace Gem\Components\Mail;

use Gem\Components\Helpers\String\Builder;
use Gem\Components\Helpers\Config;
use Gem\Components\Mail\Content\Manager;
use PHPMailer;
use RuntimeException;

class Sender extends PHPMailer
{

    use Builder;
    use Config;

    private $configs;

    /**
     * Başlatıcı fonksiyondur, $optipns => host, username, password gibi bilgiler girilebilir
     * @param array|string $options
     * @param boolean $exceptions
     */
    public function __construct($options = [], $exceptions = false)
    {
        $this->getConfig('mail');
        parent::__construct($exceptions);
        $this->isSMTP();
        $this->SMTPAuth = true;
        $this->setOptions(
            $this->getOptions($options)
        );
    }

    /**
     * Eğer $options array ise kendisini döndürür, eğer değilse mail ayarlarından string e göre veri çeker.
     * @see application/Configs/mail.php
     * @param array|string $options
     * @return array
     */
    private function getOptions($options)
    {

        if (is_array($options)) {

            return $options;

        } elseif (is_string($options)) {

            if(isset($this->configs[$options])){
                return $this->configs[$options];
            }
        }
    }

    /**
     * PHPMailer sınıfa bazı bilgileri gönderir.
     * @param array $options
     */
    private function setOptions(array $options = [])
    {

        foreach ($options as $key => $value) {

            $this->$key = $value;
        }
    }

    /**
     *
     * Mesajın kimden gittiğini gösteren bilgiler atanır
     * @param string $adress
     * @param string $name
     * @return \Gem\Components\Mail\Sender
     */
    public function from($address, $name = '')
    {

        $this->setFrom($address, $name);
        return $this;
    }

    /**
     *
     * Sınıfın kime gideceğini atar, birden çok kullanımda birden çok adress atanır
     * @param string $address
     * @param string $name
     * @return \Gem\Components\Mail\Sender
     */
    public function to($address, $name = '')
    {

        $this->addAddress($address, $name);
        return $this;
    }

    /**
     * Mail'e konu ataması yapar
     * @param string $subject
     * @return \Gem\Components\Mail\Sender
     */
    public function subject($subject)
    {

        $this->Subject = $subject;
        return $this;
    }

    /**
     * Mail'in hangi charset ile gönderileceğini atar.
     * @param string $charset
     * @return \Gem\Components\Mail\Sender
     */
    public function charset($charset)
    {

        $this->CharSet = $charset;
        return $this;
    }

    /**
     * İçerik ataması yapar.
     * @param Manager $content
     * @return \Gem\Components\Mail\Sender
     */
    public function content(Manager $content)
    {

        $contents = $content->getContent();
        $this->msgHTML($contents);

        return $this;
    }

    /**
     * Maili gönderir
     * @return boolean
     * @throws RuntimeException
     */
    public function sendMail()
    {


        if ($this->send()) {

            return true;

        } else {

            throw new RuntimeException(
              sprintf('Mail Gönderilirken bir hata oluştu : %s',
                  $this->ErrorInfo)
            );
        }
    }

}
