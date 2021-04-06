<?php
class BBRegistry
{

	protected $_registry;

	public function __construct()
	{
		if(!isset($GLOBALS['BBRegistry']))
			$GLOBALS["BBRegistry"] = &$this;
		$this->_registry = array();
	}

	public static function set($name,$object)
	{
		BBRegistry::getInstance()->_set($name,$object);
	}

	public static function get($name)
	{
		return BBRegistry::getInstance()->_get($name);
	}

	public static function exists($name)
	{
		return BBRegistry::getInstance()->_isSet($name);
	}
	
	public static function getInstance()
	{
		if(isset($GLOBALS["BBRegistry"])) return $GLOBALS["BBRegistry"];
		$me = new BBRegistry();
		return $me->getInstance();
	}

	protected function _set($name,$object)
	{
		$this->_registry[$name] = $object;
	}

	protected function _get($name)
	{
		if(isset($this->_registry[$name]))
			return $this->_registry[$name];
		throw new Exception("Item was was not available in the registry");
	}

	protected function _isSet($name)
	{
		return isset($this->_registry[$name]);
	}

	public function test()
	{
		if(!isset($this->test_counter)) $this->test_counter = 0;
		$this->test_counter++;
		return $this->test_counter;
	}


	public static function runTest()
	{
		$r = BBRegistry::getInstance()->test();
		$r +=BBRegistry::getInstance()->test();
		$r +=BBRegistry::getInstance()->test();
		$r +=BBRegistry::getInstance()->test();
		BBRegistry::set('test', 10);
		$r += BBRegistry::get('test');
		return $r==20;
	}
}
