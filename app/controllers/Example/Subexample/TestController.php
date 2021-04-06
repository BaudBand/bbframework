<?php
class Example_Subexample_TestController extends BBControllerAbstract {

	protected function _getViewDir() { return "examples"; }
	public function helloAction()
	{
		$this->renderView("hello.php","basic","Hello World", array("HELLO"=>"Hello World!"));
		return;
	}

}
