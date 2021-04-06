<?php
class ErrorController extends BBControllerAbstract 
{
	protected function _getViewDir() { return "errors"; }

	public function notfoundAction()
	{
		$this->renderView("notfound.php","basic","File Not Found");
	}
}
