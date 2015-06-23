<?php

namespace Gem\Components\Adapter;
/**
 *
 *  Bu dosya Adapter sınıfının interface dosyasıdır, Adapter sınıfına eklenecek her dosya bu interface sahip olmak zorundadır
 *
 */

interface AdapterInterface{

     public function getName();
     public function boot();

}
