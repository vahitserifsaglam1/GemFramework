<?php
    /**
     * Bu sınıf GemFrameworkde Database sınıfında join komutları üretmek
     * için kullanılır
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     */

    namespace Gem\Components\Database\Builders;

    class Join
    {

        /**
         * Join Metnini oluşturur
         * @param array  $join
         * @param string $table
         * @return string
         */
        public function join(array $join = [], $table = '')
        {
            $string = '';
            foreach($join as $values)
            {
                foreach($values as $type => $value)
                {
                    $string .= sprintf("%s %s ON %s.%s = %s.%s",$type, $value[0], $value[0], $value[1],$table, $value[2]);
                }
            }

            return $string;
        }

    }