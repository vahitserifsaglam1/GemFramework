<?php
    /**
     *  Bu Sınıf GemFramework'de Veritabanı işlemlerini yapmak için tasarlanmıştır
     */

    namespace Gem\Components\Orm;

    use Gem\Components\Database\Base;
    use Gem\Components\Database\Mode\Delete;
    use Gem\Components\Database\Mode\Read;
    use Gem\Components\Database\Mode\Update;
    use Gem\Components\Database\Mode\Insert;

    /**
     * Class Orm
     *
     * @package Gem\Components\Orm
     */
    class Orm
    {

        private $where;
        private $orWhere;
        private $set;
        private $select;
        private $limit;
        private $group;
        private $order;
        private $page;
        private $orderType;
        private $table;
        private $db;
        private $join;

        /**
         * Sınıfı ve Ebeveyn sınıfı başlatır.
         */
        public function __construct()
        {
            $this->db = new Base();
        }

        /**
         * @param int $id
         * @return $this
         */
        public function find($id = 1)
        {
            $this->where('id', $id);

            return $this;
        }

        /**
         * Sorguya join kodu ekler
         * @param array $join
         * @return $this
         */
        public function join(array $join = [])
        {
            $this->join = $join;
            return $this;
        }
        /**
         * Sorguya where komutu ekler
         *
         * @param      $id
         * @param null $controll
         * @return $this
         */
        public function where($id, $controll = null)
        {
            if (!is_array($id) && !is_array($controll)) {
                $this->where[] = [$id, '=', $controll];
            } elseif (is_array($id) && is_null($controll)) {
                $this->where = $id;
            }

            return $this;
        }

        /**
         * Sayfalama yapabilmek sayfa numarasını alır
         *
         * @param int $page
         * @return $this
         */
        public function page($page = 1)
        {
            $this->page = $page;

            return $this;
        }

        /**
         * Sorguya or where komutu ekler
         *
         * @param      $id
         * @param null $controll
         * @return $this
         */
        public function orWhere($id, $controll = null)
        {
            if (!is_array($id) && !is_array($controll)) {
                $this->orWhere[] = [$id, '=', $controll];
            } elseif (is_array($id) && is_null($controll)) {
                $this->orWhere = array_merge($this->where, $id);
            }

            return $this;
        }

        /**
         * Sorguya grup komutu ekler
         *
         * @param string $group
         * @return $this
         */
        public function group($group = '')
        {
            $this->group = $group;

            return $this;
        }

        /**
         * Kullanılacak tabloyu atar
         *
         * @param string $table
         * @return $this
         */
        public function setTable($table = '')
        {
            $this->table = $table;

            return $this;
        }

        /**
         * @param array $limit
         * @return $this
         */
        public function limit($limit = [])
        {
            $this->limit = $limit;

            return $this;
        }


        /**
         * Mysql veri sıralama sistemini yapar
         *
         * @param        $order
         * @param string $type
         * @return $this
         */
        public function order($order, $type = 'DESC')
        {
            $this->order = $order;
            $this->orderType = $type;

            return $this;
        }

        /**
         * Sorguya set ekler
         *
         * @param array $set
         * @return $this
         */
        public function set(array $set = [])
        {

            $this->set = $set;

            return $this;
        }

        /**
         * Sorguya select kodunu ekler
         *
         * @param array $select
         * @return $this
         */
        public function select(array $select = [])
        {
            $this->select = $select;

            return $this;
        }


        /**
         * Veriyi okur
         *
         * @return mixed
         */
        public function read()
        {
            $app = $this;
            $return = $app->db->read($this->table, function (Read $mode) use ($app) {
                if (isset($app->where)) {
                    $mode->where($app->where);
                }
                if (isset($app->select)) {
                    $mode->where($app->where);
                }
                if (isset($app->join)) {
                    $mode->join($app->join);
                }
                if (isset($app->group)) {
                    $mode->group($app->group);
                }
                if (isset($app->limit)) {
                    $mode->limit($app->limit);
                }
                if (isset($app->page)) {
                    $mode->page($app->page);
                }
                if (isset($app->order) && isset($app->orderType)) {
                    $mode->order($app->order, $app->orderType);
                }
                if (isset($app->orWhere)) {
                    $mode->orWhere($app->orWhere);
                }

                return $mode->build();
            });

            return $return;
        }

        /**
         * Mysql üzerinde güncelleme işlemi yapar
         *
         * @return mixed
         */
        public function update()
        {
            $app = $this;

            return $this->db->update($this->table, function (Update $mode) use ($app) {
                if (isset($app->where)) {
                    $mode->where($app->where);
                }

                if (isset($this->set)) {
                    $mode->set($app->set);
                }

                return $mode->run();
            });
        }

        /**
         * Veritabanına veri ekleme işlemi yapar
         *
         * @return mixed
         */
        public function insert()
        {
            $app = $this;

            return $this->db->insert($this->table, function (Insert $mode) use ($app) {

                if (isset($app->set)) {
                    $mode->set($app->set);
                }

                return $mode->run();
            });
        }

        /**
         * Veritabanndan veri silme işlemi yapar
         *
         * @return mixed
         */
        public function delete()
        {
            $app = $this;

            return $this->db->delete($this->table, function (Delete $mode) use ($app) {
                if (isset($app->where)) {
                    $mode->where($app->where);
                }

                return $mode->run();
            });
        }
    }