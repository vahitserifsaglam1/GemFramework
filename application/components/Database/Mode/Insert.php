<?php

namespace Gem\Components\Database\Mode;

use Gem\Components\Database\Base;
use Gem\Components\Database\Mode\ModeManager;
use Gem\Components\Helpers\Database\Where as WhereTrait;

class Insert extends ModeManager
{

    use WhereTrait;

    public function __construct(Base $base)
    {

        $this->setBase($base);


        $this->string = [

            'from' => $this->getBase()->getTable(),
            'insert' => null,
            'parameters' => [],
        ];

        $this->setChield($this);

        $this->setChieldPattern('insert');
    }

    /**
     *
     * @param array $set
     */
    public function set($set = [])
    {

        $insert = $this->databaseSetBuilder($set);
        $this->string['insert'] .= $insert['content'];
        $this->string['parameters'] = array_merge($this->string['parameters'], $insert['array']);
        return $this;
    }

}
