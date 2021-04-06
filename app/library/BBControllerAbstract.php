<?php
abstract class BBControllerAbstract {

	abstract protected function _getViewDir();

	public function renderView($file,$template,$title,$data=array()) 
	{
		$path = APP_DIR . "/views/" . $this->_getViewDir() . "/" . $file;
		if(!($view = file_get_contents($path)))
			throw Exception("View not found");
		foreach($data as $key => $d)
			$view = str_replace("{{".$key."}}", $d, $view);

		$path = APP_DIR . "/templates/$template" . ".php";
		if(!($page = file_get_contents($path)))
			throw Exception("Template $template not found.");
		$page = str_replace("{{APP.NAME}}", APP_NAME, $page);
		$page = str_replace("{{PAGE.TITLE}}", $title, $page);
		$page = str_replace("{{PAGE.CONTENT}}", $view, $page);
		eval("?>".$page);
	}



	public function redirect($url)
	{
		header("Location: $url");
		exit();
	}

}
