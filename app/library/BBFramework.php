<?php
class BBFramework {

	/**
	 * BASIC MVC FRAMEWORK
	 *
	 * Automatically identifies controller and action requested, additional items are classes as parameters.
	 *
	 * For example:
	 *
	 * www.website.com/admin/manage/user/uid/35566 
	 *
	 * Would parse as Admin_ManageController (located in controllers/Admin/ManageController.php) and would make 
	 * "userAction" the action function, and store the parameters "uid"=>"35566".
	 *
	 *
	 **/
	
	public function route($url=false)
	{
		if(!$url) $url = $_SERVER['REQUEST_URI'];
		if(preg_match("/^[\/]+index\.php/", $url)) $url = "";
		$route = $this->_decodeUrl(APP_DIR . "/controllers", $url);
		try
		{
			if(@include_once($route['path']))
			{
				if(!class_exists($route["controller"]))
					throw new Exception('Controller file found, but class ' . $route["controller"] . ' was not found.');
				
				$controller = new $route["controller"];
				if(!($controller instanceof BBControllerAbstract))
					throw new Exception($route["controller"] . " does not abstract from BBControllerAbstract");
				if(method_exists($controller, $route["action"]))
					call_user_func(array($controller, $route["action"]));
				else
					throw new Exception($route["action"] . " is not a valid action");
			}
			else
				throw new Exception($route['path'] . " does not exist");
		
		} 
		catch(Exception $e) 
		{
			if(!preg_match("/^[\/]+error/", $url))
				$this->route("/error/notfound");
		}
	}

	protected function _decodeUrl($path, &$matches, $offset=0)
	{
		if(!is_array($matches))
		{
			$matches = preg_replace("/^\//", "", $matches);
			$matches = explode("/", $matches);
			for($idx=0; $idx < sizeof($matches); $idx++)
				$matches[$idx] = ucwords(preg_replace("/[^A-Za-z0-9_]/", "", $matches[$idx]));
		}
		// Check for "/" - index
		if(!is_array($matches) || sizeof($matches)<2)
		{
       			return [
               	 		"path"       =>  APP_DIR . "/controllers/IndexController.php",
	                	"controller" =>  "IndexController",
        	        	"action"     =>  (isset($matches[0]) && $matches[0]!="" ) ? strtolower($matches[0]) . "Action" : "indexAction",
                		"params"     =>  array()
	                ];
		}
		// Check for contoller subdirectory
        	if($matches[$offset]>"" && file_exists($path . "/" . $matches[$offset]) && is_dir($path . "/" . $matches[$offset]))
		{
			// Check if we've run out of path, if so,indexAction 
			if(($offset+1) == sizeof($matches))
			{
				return [
					"path"       =>  $path . "/" . $matches[$offset] . "Controller.php",
	 				"controller" =>  implode("_", array_slice($matches,0,$offset+1))."Controller",
					"action"     =>  "indexAction",
					"params"     =>  array()
			
				];
			}
        	        return $this->_decodeUrl($path . "/" . $matches[$offset], $matches, $offset+1);
	        }
		// No subdirectory, look for controller PHP file
                if(file_exists($path . "/" . $matches[$offset] . "Controller.php"))
		{
			return [
				"path"       =>  $path . "/" . $matches[$offset] . "Controller.php",
 				"controller" =>  implode("_", array_slice($matches,0,$offset+1))."Controller",
				"action"     =>  isset($matches[$offset+1]) ? strtolower($matches[$offset+1]) . "Action" : "indexAction",
				"params"     =>  (sizeof($matches) > $offset) ? array_slice( $matches, $offset+2, sizeof($matches)-$offset) : array()
				];
		}
		else
		{
			// Check if we've run out of path, if so,indexAction 
			if(($offset+1) == sizeof($matches))
			{
				return [
					"path"       =>  preg_replace("/\/[A-Za-z0-9_-]*$/","",$path) . "/" . $matches[$offset-1] . "Controller.php",
	 				"controller" =>  implode("_", array_slice($matches,0,$offset))."Controller",
					"action"     =>  "indexAction",
					"params"     =>  array()
			
				];
			}
		}
		// No result returned yet, so most not have found what we were looking for, direct request to error page
		return [
               	 	"path"       =>  APP_DIR . "/controllers/ErrorController.php",
                	"controller" =>  "ErrorController",
                	"action"     =>  "notfoundAction",
                	"params"     =>  array()
                ];
	}
}
