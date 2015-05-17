<?php
/**
 *
*  GemFramework Controller Trait -> bu trait ile model instance i oluþturulur
*
*  @package Gem\Components\Helpers\Make
*  @author vahitserifsaglam <vahit.serif119@gmail.com>
*/

namespace Gem\Components\Helpers\Make;


trait Model{

	/**
	 * Yeni bir kontroller instance oluþturur
	 * @param string $controller
	 * @return Ambigous <object, NULL>
	 */


	public function makeModel($model)
	{
			
		$modelName = $model;
			
		$modelPath = APP.'Models/'.$modelName.'.php';
			
		if(file_exists($modelPath))
		{

			if(!class_exists($model))
			{
					
				include $modelPath;
					
			}

			$model = new $modelName;

		}
		else
		{

			$model = null;

		}
			
		return $model;
			
	}


}