<?php

/**
 * 
 *  @package  Gem\Components\Database\Base;
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 *  
 */

namespace Gem\Components\Database\Mode;

use Gem\Components\Database\Traits\Builder;
use Gem\Components\Database\Builders\BuildManager;

class ModeManager {

    use Builder;
    ## Gem\Components\Database\Base	

    /**
     * 
     * @var Gem\Components\Database\Base
     */
    private $base;

    /**
     * 
     * @var array
     */
    private $builders;
    private $chieldPattern;
    private $chield;
    private $patterns = [

        'read' => [

            'SELECT :select FROM :from :group WHERE:where :order :limit',
            'SELECT :select FROM :from :group :order :limit'
        ],
        'update' => [

            'UPDATE :from SET :update WHERE:where'
        ],
        'delete' => [

            'DELETE FROM :from WHERE:where'
        ],
        'insert' => [

            'INSERT INTO :from :insert'
        ]
    ];

    /**
     * 
     * @return \Gem\Components\Database\Base
     */
    public function getBase() {

        return $this->base;
    }

    /**
     * Patterin i atar
     * @param string $pattern
     */
    protected function setChieldPattern($pattern) {

        $this->chieldPattern = $pattern;
    }

    /**
     * Uygulanan pattern i g�sterir
     * @return string 
     */
    protected function getChieldPattern() {

        return $this->chieldPattern;
    }

    /**
     * veleti g�nderir
     * @param  $chield
     */
    protected function getChield() {

        return $this->chield;
    }

    protected function setChield($chield) {


        $this->chield = $chield;
    }

    /**
     * Yeni bir query Sorgusu olu�turur
     * @return \Gem\Components\Database\Builders\BuildManager
     */
    public function getQuery() {

        $strings = $this->string;
        $query = $this->buildQuery($this->getPattern($this->getChieldPattern()), $strings);
        return $query;
    }

    /**
     * Sorguyu buildManager ��ine atar
     * @return \Gem\Components\Database\Builders\BuildManager
     */
    public function build() {

        $query = $this->getQuery();
        $manager = new BuildManager($this->getBase()->getConnection());
        $manager->setQuery($query);
        $manager->setParams($this->string['parameters']);

        return $manager;
    }

    /**
     * Query i �al��t�r�r
     * @return \PDOStatement
     */
    public function run() {

        return $this->build()->run();
    }

    /**
     * veleti �a��r�r
     */
    protected function getCield() {

        return $this->chield;
    }

    protected $string;

    /**
     * 
     * @param Gem\Components\Database\Base $base
     */
    public function setBase($base) {

        $this->base = $base;
    }

    /**
     * 
     * @param array $builders
     */
    protected function useBuilders($builders = []) {

        $this->builders = $builders;
    }

    /**
     * 
     * @param string $builderName
     * @return multitype:mixed
     */
    protected function useBuilder($builderName) {

        if (isset($this->builders[$builderName])) {

            return $this->builders[$builderName];
        }
    }

    /**
     * 
     * @param string $pattern
     * @return multitype:multitype:string
     */
    protected function getPattern($pattern) {

        if (isset($this->patterns[$pattern])) {

            return $this->patterns[$pattern];
        }
    }

    /**
     * 
     * Pattern atamas� yapar
     * @param string $name
     * @param array $patterns
     */
    protected function setPattern($name, array $patterns) {

        $this->patterns[$name] = $patterns;
    }

    /**
     * Where tetiklenir
     * @param unknown $args
     * @param unknown $type
     */
    private function doWhere($where, $type) {

       
        
        switch ($type) {

            case 'and':

                $where = $this->useBuilder('where')
                        ->where($where, $this->getCield());

                break;

            case 'or':

                $where = $this->useBuilder('where')
                        ->orWhere($where, $this->getCield());

                break;
        }


        $this->string['where'] = $where['content'];
        $this->string['parameters'] = array_merge($this->string['parameters'], $where['array']);
    }

    /**
     * Where  sorgusu
     * @param mixed $where
     */
    public function where($where, $controll = null) {

        if(!is_array($where) && !is_null($controll)){
            
            $where = [
                [$where,'=', $controll]
            ];
            
        }elseif(is_array($where) && isset($where[0]) && isset($where[1])){
            
            if(is_string($where[1])){
                
                $where = [
                    [$where[0], $where[1], $where[2]]
                ];
                
            } 
            
        }
        
        $this->doWhere($where, 'and');

        return $this;
    }

    /**
     * OrWhere sorgusu
     * @param mixed $where
     */
    public function orWhere($where) {

        $this->doWhere($where, 'or');
    }

    /**
     * @return string
     */
}
