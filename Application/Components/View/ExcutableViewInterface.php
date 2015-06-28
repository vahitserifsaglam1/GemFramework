<?php

namespace Gem\Components\View;
interface ExcutableViewInterface{

    public static function make($fileName = '', $params = []);
    public function execute();

}
