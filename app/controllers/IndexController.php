<?php 
class IndexController extends BBControllerAbstract {

	protected function _getViewDir() { return "index"; }

	public function indexAction()
	{
		$this->renderView("index.php","basic","Index Page");
	}

	public function altestAction()
	{
		$model = new Test_Model();
		echo $model->multiply(7,12);
	}

	public function dataAction()
	{
		require(APP_DIR . "/models/Data/CategoryExample.php");
		$data= new Data_CategoryExample();
		$this->results = $data->getAll();
		$this->renderView("data.php","basic","MySQL Example", array());
	}


}
