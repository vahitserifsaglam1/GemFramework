<?php
	 /**
	  *  Bu Dosya GemFramework' event sınıfını kullanıma hazırlar
	  * @author vahitserifsaglam <vahit.serif119@gmail.com>
	  */
	namespace Gem\Components\Event;

	 use Gem\Components\Application;

	 /**
	  * Class EventProvider
	  * @package Gem\Manager\Providers
	  */
	 class EventProvider
	 {

		  /**
			* Event Dosyaları buraya girilir
			*  Girilim Biçimi
			*
			*  'EventSınıfı' => [
			*              'EventDinleyicisi1',
			*              'EventDinleyicisi2'
			*                   ]
			*
			* @var array
			*/
		  protected $events = [

				'Gem\Events\Header' => [
					 'Gem\Listeners\HeaderListener'
				],
				'Gem\Events\Kategori' => [
					 'Gem\Listeners\KategoriListener'
				],
				'Gem\Events\Ders' => [
					 'Gem\Listeners\DersListener'
				]
		  ];

		  /**
			* Events sınıfını oluşturur ve listener ları atar
			* @param Application $application
			*/
		  public function __construct (Application $application)
		  {
				$event = $application->singleton ('Gem\Components\Event\EventCollector', [ $application ]);
				$event->setListeners ($this->events);
				$application->singleton ('Gem\Components\Event', [ $event ]);


		  }
	 }
