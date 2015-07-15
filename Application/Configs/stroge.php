<?php

    /**
     *  Bu Dosyadan Session, Cookie, Redis gibi depoloma ayarlarını değiştirebilirsiniz
     * @author vahitserifsaglam <vahit.serf119@gmail.com>
     */

    return [

        /**
         *  Bu Kısımdan Mecmache sınıfında kullanılacak ayarlara erişebilirsiniz
         *  | *********************************************************
         *  | host = memcache in bağlanacağı adres, genellikle localhost olur
         *  | port = memcacha'in bağlanacağı kanal,
         *  | *********************************************************
         */

        'memcache' => [
            'host' => '127.0.0.1',
            'port' => 11211
        ],
        /**
         *  Bu Kısımdan Redis sınıfında kullanılacak ayarlara erişebilirsiniz
         *  | *********************************************************
         *  | host = redis in bağlanacağı adres, genellikle localhost olur
         *  | port = redis'in bağlanacağı kanal,
         *  | timeout = redis bağlantısı için  beklenilecek süre
         *  | *********************************************************
         */
        'redis' => [
            'host' => 'localhost',
            'port' => 6379,
            'timeout' => 3
        ]
    ];