<?php

	 return [
		  'connection' => [

				/**
				 *  Bu Kısımdan Veritabanı ayarlarınızı düzenleyebilirsiniz.
				 *  host = Veritabanının sunucusu
				 *  db = Veritabanı adı
				 *  username = veritabanı kullanıcı adı
				 *  password = veritabanı şifresi
				 *  charset =  Veritabanı bağlantısı başlatılırken ayarlanacak charset değeri
				 *  ********
				 *  driver = Veritabanında kullanılacak sürücü, pdo veya mysqli kullanılabilir.( Ön tanımlı olarak pdo gelmektedir )
				 *  type = Eğer Sürücü olarak pdo seçilmişse, pdo nun desteklediği herhangi bir sql tipi girilebilir. ( Ön tanımlı olarak mysql gelmektedir )
				 *
				 */

				'host'     => 'localhost',
				'db'       => 'dt',
				'username' => 'root',
				'password' => '',
				'charset'  => 'utf-8',
				'driver'   => 'pdo' ],

		  /**
			*  Bu Kısımda Auth Sınıfının Kullanıcı işlemlerini yapabilmesi için gerekli değerleri veriyoruz.
			*
			*/
		  'user'       => [

				/**
				 *  Table = Veritabanında kullanıcı verilerinin saklandığı tablo
				 */

				'table'    => 'user',
				/**
				 *  Login = Auth::login fonksiyonunda doğrulanacak veriler, sadece 2 değer olmak zorundadır.
				 */

				'login'    => [
					 'username', 'password' ],
				/**
				 *  Register = Auth::register fonksiyonunda kullanıcının kayıt edilirken girmesi gerekecek verileri burada saklıyoruz.
				 */
				'register' => [
					 'username', 'password', 'email', 'name', 'phone' ],
				/**
				 *  Columns = Auth::login'de veritabanında çekilecek sütünlar'ın adları girilir, daha sonra bunları sesison dan çekerek kullanabilirsiniz.
				 */
				'columns'  => [
					 'username', 'email', 'name' ] ] ];
