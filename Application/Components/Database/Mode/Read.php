<?php

    /**
     *  GemFramework Database Read Mode -> veritabanından veri okumakda kullanılır
     *
     * @package Gem\Components\Database\Mode
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     */

    namespace Gem\Components\Database\Mode;

    use Gem\Components\Database\Base;
    use Gem\Components\Database\Builders\Group;
    use Gem\Components\Database\Builders\Join;
    use Gem\Components\Database\Builders\Limit;
    use Gem\Components\Database\Builders\Order;
    use Gem\Components\Database\Builders\Select;
    use Gem\Components\Database\Builders\Where;
    use Gem\Components\Database\Traits\Builder;
    use Gem\Components\Helpers\Config;

    class Read extends ModeManager
    {

        use Builder;

        private $as;

        public function __construct(Base $base)
        {

            $this->setBase($base);
            $this->useBuilders([

                'where' => new Where(),
                'select' => new Select(),
                'order' => new Order(),
                'limit' => new Limit(),
                'group' => new Group(),
                'join' => new Join(),
            ]);

            $this->string = [

                'select' => '*',
                'from' => $this->getBase()->getTable(),
                'join' => null,
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
         *
         * @param string $select
         * @return $this
         */
        public function select($select = null)
        {

            $this->string['select'] = $this->useBuilder('select')
                ->select($select, $this->cleanThis());

            return $this;
        }

        private function cleanThis()
        {

            return new static($this->getBase());
        }

        /**
         * Order Sorgusu olu�turur
         *
         * @param string $order
         * @param string $type
         * @return \Gem\Components\Database\Mode\Read
         */
        public function order($order, $type = 'DESC')
        {

            $this->string['order'] .= $this->useBuilder('order')
                ->order($order, $type);

            return $this;
        }

        /**
         * Join komutu ekler
         *
         * @param array $join
         * @return $this
         */
        public function join($join = [])
        {
            $this->string['join'] = $this->useBuilder('join')->join($join, $this->getBase()->getTable());
            return $this;
        }

        /**
         * @param int $page
         * @return \Gem\Components\Database\Mode\Read
         */
        public function page($page)
        {
            $this->page = $page;
            $limit = Config::get('db.pagination');
            $limit = $limit['limit'];
            $baslangic = ($page - 1) * ($limit);
            $bitis = $page * $limit;

            return $this->limit([$baslangic, $bitis]);
        }


        /**
         * Group By sorgusu ekler
         *
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
         * İç içe bir sorgu oluşturur
         *
         * @param string $as
         * @param mixed $select
         * @return  \Gem\Components\Database\Mode\Read
         */
        public function create($as, $select)
        {

            $this->setAs($as);

            return $this->select($select);
        }

        /**
         * Limit sorgusu olu�turur
         *
         * @param string $limit
         * @return \Gem\Components\Database\Mode\Read
         */
        public function limit($limit)
        {

            $this->string['limit'] .= $this->useBuilder('limit')
                ->limit($limit);

            return $this;
        }

        /**
         * @param string $as
         * @return \Gem\Components\Database\Mode\Read
         */
        public function setAs($as)
        {

            $this->as = $as;

            return $this;
        }

        /**
         * Select de kullanılacak as değerini döndürür
         *
         * @return string
         */
        public function getAs()
        {

            return $this->as;
        }

        /**
         * Etkilenen elaman sayısını döndürür
         *
         * @return int
         */

        public function rowCount()
        {

            return $this->build()->rowCount();
        }


        /**
         * İçeriği tekil veya çokul olarak döndürür
         *
         * @param bool $fetchAll
         * @return array|mixed|object|\stdClass
         * @throws \Exception
         */
        public function fetch($fetchAll = false)
        {

            return $this->build()->fetch($fetchAll);
        }

        /**
         * Tüm İçeriği Döndürür
         *
         * @return array|mixed|object|\stdClass
         */
        public function fetchAll()
        {

            return $this->fetch(true);
        }
    }
