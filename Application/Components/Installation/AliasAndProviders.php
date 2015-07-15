<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Installation;


    use Gem\Components\Application;
    use Gem\Components\Helpers\Config;
    use Gem\Components\Patterns\Facade;

    class AliasAndProviders
    {

        /**
         * Takma at ve hazırlayıcıları çalıştırır
         * @param Application $app
         */
        public function __construct(Application $app)
        {

            $alias = Config::get('general.alias');
            $providers = Config::get('general.providers');

            Facade::$instance = $alias;

            foreach ($providers as $provider) {
                new $provider($app);
            }

        }

    }