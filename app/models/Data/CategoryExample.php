<?php
class Data_CategoryExample {

	protected $_mysql;
	protected $_categories;
	public function __construct()
	{
		if(BBRegistry::exists('mysql'))
			$this->_mysql = &BBRegistry::get('mysql');
		else
			$this->_mysql = false;

		$_categories = [];
	}

	public function getAll()
	{
		$this->_loadAll();
		return $this->_categories;
	}

	protected function _loadAll()
	{
		if(!$this->_mysql) return;
		$sql = "SELECT i.name as item_name, c.name as category_name,i.id,i.category_id FROM items i 
			INNER JOIN categories c ON i.category_id=c.id
			 ORDER BY c.name, i.name ASC";
		$result = $this->_mysql->query($sql);
		while($row = $result->fetch_assoc())
		{
			if(!isset($this->_categories[ (int) $row["category_id"]]))
			{
				$this->_categories[(int)$row["category_id"]]  = (object) [
					"category_name" => $row["category_name"],
					"category_id" => $row["category_id"],
					"items" => array()
					 
				];
			}
			$this->_categories[(int)$row["category_id"]]->items[(int)$row["id"]] = (object) [
					"item_name" => $row["item_name"],
					"item_id" => $row["id"]
			];
		}
	}


}
