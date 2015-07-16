<?php
    /**
     * Burada sabit tanımlama işlemleri yapılır
     *
     */
    ini_set('memory_limit', '1024M');

    /**
     *  Uygulama klasörünün sabiti
     *
     */
    define('APP', 'Application/');

    /**
     * Rötaların bulunduğu klasörün sabiti
     *
     */
    define('ROUTE', APP . 'Routes/');

    /**
     * Controller ve View dosyalarının klasör sabiti
     *
     */
    define('VC', APP . 'Http/');

    /**
     * View dosyalarının sabiti
     *
     */
    define('VIEW', VC . 'Views/');

    /**
     * Controller Dosyalarının sabiti
     *
     */
    define('CONTROLLER', VC . 'Controllers/');

    /**
     * Ayar dosyalarının sabiti
     *
     */
    define('CONFIG_PATH', APP . 'Configs/');

    /**
     * Sistem dosyaların sabiti
     */
    define('SYSTEM', 'System/');

    /**
     * Dil Dosyalarının sabiti
     *
     */
    define('LANG', 'stroge/language/');

    /**
     * CSS, JS gibi dosyaların sabiti
     */
    define('ASSETS', 'public/assets/');

    /**
     *  Veritabanı dosyalarının sabiti
     */
    define('DATABASE', APP . 'Database/');

    /**
     * Model Dosyalarının sabiti
     *
     */
    define('MODEL', DATABASE . 'Models/');


