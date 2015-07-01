<?php

	 /**
	  *  Bu Ayar Dosyası Redis Sınıfının hangi sunucu, port a ve hangi zaman aşımı süresini kullanacağını belirtir
	  *  *********************
	  *
	  *  host = Redis 'in bağlanacağı sunucu
	  *  port = Redis 'in bağlanacağı giriş(port)
	  *  timeout = Redis' hangi zaman içinde bağlanamazsa bağantıyı kapatacak ?
	  */
	 return [
		  'host'    => 'localhost',
		  'port'    => 6379,
		  'timeout' => 3 ];