<?php

namespace Gem\Components\Helpers\Database;

trait Where {

    /**
     * 
     * @param array $args
     * @param string $start
     * @return multitype:string multitype:mixed
     */
    private function databaseStringBuilderWithStart(array $args, $start) {

        $s = '';
        $arr = [];



        foreach ($args as $arg) {



            $s .= " {$arg[0]} {$arg[1]} ?";
            $arr[] = $arg[2];
        }


        if (!count($args) === 1) {

            $s = $start . $s;
        }


        return [

            'content' => $s,
            'array' => $arr
        ];
    }

    /**
     * Set verisi olu�turur
     * @param unknown $set
     * @return multitype:string multitype:array
     */
    private function databaseSetBuilder($set) {


        $s = '';
        $arr = [];



        foreach ($set as $key => $value) {
            $s .= "$key = ?,";
            $arr[] = $value;
        }



        return [

            'content' => rtrim($s, ","),
            'array' => $arr
        ];
    }

}
