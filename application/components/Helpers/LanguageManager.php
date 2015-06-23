<?php
namespace Gem\Components\Helpers;
use Gem\Components\Helpers\String\Parser;
use Gem\Components\Helpers\String\Builder;

trait LanguageManager{

    use Parser, Builder;


    /**
     *
     * @param array $language
     * @return \Gem\Components\View
     *
     *  [ 'dil' => [
     *   'file1','file2'
     *  ]
     */
    public function language($language)
    {

        if (count($language) > 0 && is_array($language)) {

            foreach ($language as $lang) {

                ## alt par�alama
                foreach ($lang as $langfile) {

                    $file = $this->joinDotToUrl($langfile);
                    $fileName = LANG . $langfile . '/' . $file . ".php";

                    if (file_exists($fileName)) {

                        $newParams = include $fileName;
                        $this->params = array_merge($this->params, $newParams);
                    }
                }
            }
        }


        return $this;
    }

}