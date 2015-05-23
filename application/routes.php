<?php

return $app->before('bb', function() {
                    return true;
                })
                ->before('aa', function() {
                    return true;
                })->
                group('test', ['aa', 'bb'])
                ->get('/', ['group' => 'test', 'action' => function() {

                        echo "hello world";
                    }]);
