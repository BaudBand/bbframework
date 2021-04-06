<h2>Data Example</h2>
<?php
	foreach($this->results as $cat)
	{
		echo "<h3>" . htmlentities($cat->category_name) . "</h3>";
		foreach($cat->items as $item)
			echo $item->item_name . "<br />";
	}
?>
