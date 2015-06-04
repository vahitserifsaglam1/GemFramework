<?php

/**
 * 
 *  GemFramework Builders Select Trait -> where sorgular� burada olu�turulur
 *  
 *  @package Gem\Components\Database\Builders
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 * 
 */

namespace Gem\Components\Database\Builders;

use Gem\Components\Database\Traits\Where as WhereTrait;

class Where {

    use WhereTrait;

    /**
     * 
     * @param array $args
     * @param string $base
     * @return Ambigous <multitype:string , multitype:string multitype:array  >
     */
    public function where($args, $base) {

        if (is_array($args)) {

            return $this->databaseStringBuilderWithStart($args, ' AND');
        } else {

            return $args($base);
        }
    }

    /**
     * 
     * @param array $args
     * @param Base $base
     * @return Ambigous <multitype:string , multitype:string multitype:array  >
     */
    public function orWhere($args, $base) {

        if (is_array($args)) {

            return $this->databaseStringBuilderWithStart($args, ' OR');
        } else {

            return $args($base);
        }
    }

}
