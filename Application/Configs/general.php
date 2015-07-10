<?php

return [

    /**
     *
     * Bu Kısımda Facade olayında kullanılacak isimler ve Çağrılacak isimleri belirliyoruz,
     * Facade Sınıfında return "Auth"; yapıldığı zaman Gem\Components\Auth Sınıfının çağrılması bu sayede olmaktadır,
     * Her Facade sınıfında buranın kullanılması zorunlu değildir, facede sınıfında return olarak bir sınıf örneği döndürürseniz
     * O örnek kullanılacaktır
     *
     */

    'alias' => [
        'Auth' => 'Gem\Components\Auth',
        'Cookie' => 'Gem\Components\Cookie',
        'Event' => 'Gem\Components\Event',
        'Route' => 'Gem\Components\Route\RouteCollector',
        'Session' => 'Gem\Components\Session',
        'Request' => 'Gem\Components\Http\Request'
    ],

    /**
     *  Bu Provider's kısmı Laravel'de ServiceProvider olarak bilinen olay yerine kullanılır
     *  Provider's ler genelde Application/Manager yolunda yer alır.
     *  Namespace olarak Gem\Manager\Providers' e sahiplerdir.
     *  Eklemek istediğini Provider'sleri buraya eklemeniz yeterlidir.
     *
     */

    'providers' => [
        'Gem\Manager\Providers\RouteProvider',
        'Gem\Manager\Providers\EventProvider',
        /**
         *  Buradaki CsrfTokenProvider' ı etkinleştirirseniz her post işleminde csrftoken değerini
         *  araycaktır
         *
         */

        # 'Gem\Manager\Providers\CsrfTokenProvider'
    ],


    /**
     * Bu Kısımda View' sınıfı ile ilgili yapıları düzenleyebilirsiniz,
     * headerFiles ve footerFiles ayarları View sınıflarında(twig,view) ->footerFile(), ->headerFile() fonksiyonlarını kullanmadan
     * header ve footer dosyalarını çekebilmenizi sağlar, bu ayarlar sınıf başlar başlamaz atanır.
     */

    'view' => [

        /**
         *  Header Dosyalarını burada array içinde girmelisiniz, birden fazla header dosyası eklerseniz yukardan aşağıya doğru
         *  sırayla yüklenir
         *  Verileri girererken klasor/dosyaAdı şeklinde giriniz
         *  Not: dosya adından sonra uzantısını .php olarak otamatik atanmaktadır, uzantı girmeyiniz.
         */
        'headerFiles' => [
            'inc/header'],

        /**
         *  footer Dosyalarını burada array içinde girmelisiniz, birden fazla footer dosyası eklerseniz yukardan aşağıya doğru
         *  sırayla yüklenir
         *  Verileri girererken klasor/dosyaAdı şeklinde giriniz
         *  Not: dosya adından sonra uzantısını .php olarak otamatik atanmaktadır, uzantı girmeyiniz.
         */

        'footerFiles' => [
            'inc/footer']]
];