<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Thread;

    use Exception;

    /**
     * Class AsyncThreadCollection
     * @package Gem\Components\Thread
     */
    class AsyncThreadCollection
    {

        /**
         * @var array
         */
        private $collections = [];

        /**
         * @param array $collections
         */
        public function __construct(array $collections = [])
        {
            $this->setCollections($collections);
        }


        /**
         * Koleksiyonları atar
         * @param array $collections
         * @return $this
         */
        public function setCollections(array $collections = [])
        {
            $this->collections = $collections;
            return $this;
        }


        /**
         * @return array
         */
        public function getCollections()
        {
            return $this->collections;
        }


        /**
         * @param string $id
         * @throws Exception
         * @return AsyncThread
         */
        public function getItem($id = '')
        {
            $collection = $this->collections[$id];

            if ($collection instanceof AsyncThread) {
                return $collection;
            } else {
                throw new Exception(sprintf('%d itemindeki içerik AsyncThread e ait bir örnek değil', $id));
            }
        }

        /**
         * Yeni bir koleksiyon ekler
         * @param AsyncThread $thread
         * @return $this
         */
        public function addItem(AsyncThread $thread)
        {
            $this->collections[] = $thread;
            return $this;
        }

        /**
         * Koleksiyon itemini siler
         * @param int $collectionKey
         */
        public function removeItem($collectionKey = 0)
        {
            if (isset($this->collections[$collectionKey])) {
                unset($this->collections[$collectionKey]);
            }
        }

        /**
         * ItemId null dışında bir integer girilirse o item tetiklenir, eğer null kalırsa hepsi tetiklenir
         * @throws Exception
         * @param null $itemId
         */

        public function run($itemId = null)
        {
            if (is_integer($itemId)) {
                if (isset($this->collections[$itemId])) {
                    $item = $this->getItem();
                    $item->start();
                    $item->join();
                }
            } elseif (is_null($itemId)) {
                foreach ($this->getCollections() as $key => $collection) {

                    if ($collection instanceof AsyncThread) {
                        $collection->start();
                        $collection->join();
                    } else {
                        throw new Exception(sprintf('%d itemindeki içerik AsyncThread e ait bir örnek değil', $key));
                    }

                }
            }

        }
    }