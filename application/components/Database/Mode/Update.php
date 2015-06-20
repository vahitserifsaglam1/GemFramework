<?php

namespace Gem\Components\Database\Mode;

use Gem\Components\Database\Mode\ModeManager;
use Gem\Components\Database\Builders\Where;
use Gem\Components\Helpers\Database\Where as WhereTrait;
use Gem\Components\Database\Base;

class Update extends ModeManager
{

    use WhereTrait;

    public function __construct(Base $base)
    {

        $this->setBase($base);

        $this->useBuilders([
            'where' => new Where()
        ]);

        $this->string = [

            'from' => $this->getBase()->getTable(),
            'update' => null,
            'where' => null,
            'parameters' => [],
        ];

        $this->setChield($this);

        $this->setChieldPattern('update');
    }

    /**
     *
     * @param array $set
     */
    public function set($set = [])
    {

        $update = $this->databaseSetBuilder($set);
        $this->string['update'] .= $update['content'];
        $this->string['parameters'] = array_merge($this->string['parameters'], $update['array']);
        return $this;
    }

}
