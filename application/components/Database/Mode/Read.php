<?php

/**
 * 
 *  GemFramework Database Read Mode -> veritaban�ndan veri okumakda kullan�l�r
 * 
 *  @package Gem\Components\Database\Mode
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 * 
 */

namespace Gem\Components\Database\Mode;

use Gem\Components\Database\Base;
use Gem\Components\Database\Mode\ModeManager;
use Gem\Components\Database\Builders\Where;
use Gem\Components\Database\Builders\Select;
use Gem\Components\Database\Builders\Order;
use Gem\Components\Database\Traits\Builder;
use Gem\Components\Database\Builders\Limit;
use Gem\Components\Database\Builders\Group;
use Gem\Components\Helpers\Config;
class Read extends ModeManager {

    use Builder,Config;

    private $as;

    public function __construct(Base $base) {

        $this->setBase($base);
        $this->useBuilders([

            'where'  => new Where(),
            'select' => new Select(),
            'order'  => new Order(),
            'limit'  => new Limit(),
            'group'  => new Group()
        ]);

        $this->string = [

            'select' => '*',
            'from' => $this->getBase()->getTable(),
            'group' => null,
            'where' => null,
            'order' => null,
            'limit' => null,
            'parameters' => [],
        ];

        $this->setChield($this);

        $this->setChieldPattern('read');
    }

    /**
     * Select sorgusu olu�turur
     * @param string $select
     */
    public function select($select = null) {

        $this->string['select'] = $this->useBuilder('select')
                ->select($select, $this->cleanThis());


        return $this;
    }

    private function cleanThis() {

        return new static($this->getBase());
    }

    /**
     * Order Sorgusu olu�turur
     * @param string $order
     * @param string $type
     * @return \Gem\Components\Database\Mode\Read
     */
    public function order($order, $type = 'DESC') {

        $this->string['order'] .= $this->useBuilder('order')
                ->order($order, $type);

        return $this;
    }
    
    /**
     * 
     * @param int $page
     * @return \Gem\Components\Database\Mode\Read
     */
    public function page($page)
    {
        
        $limit = $this->getConfig('pagination');
        $limit = $limit['limit'];
        $baslangic = ($page-1)*($limit);
        $bitis = $page*$limit;
        $this->limit([$baslangic,$bitis]);
    }


    /**
     * Group By sorgusu ekler
     * @param string $group
     * @return \Gem\Components\Database\Mode\Read
     */
    public function group($group)
    {
        
        $this->string['group'] = $this->useBuilder('group')
                ->group($group);
        
        return $this;
    }

    /**
     * 
     * İç içe bir sorgu oluşturur
     * @param string $as
     * @param mixed $select
     * @return @return \Gem\Components\Database\Mode\Read     
     */
    public function create($as, $select) {

        $this->setAs($as);

        return $this->select($select);
    }

    /**
     * Limit sorgusu olu�turur
     * @param string $limit
     * @return \Gem\Components\Database\Mode\Read
     */
    public function limit($limit) {

        $this->string['limit'] .= $this->useBuilder('limit')
                ->limit($limit);

        return $this;
    }

    /**
     * 
     * @param string $as
     * @return \Gem\Components\Database\Mode\Read
     */
    public function setAs($as) {

        $this->as = $as;
        return $this;
    }

    /**
     * As i d�nd�r�r
     * @return string
     */
    public function getAs() {

        return $this->as;
    }

}
