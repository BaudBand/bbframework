<?php
require("./config/config.php");
$mysql = new mysqli(MYSQL_HOST,MYSQL_USER,MYSQL_PASS,MYSQL_DB);

$sql = "CREATE TABLE IF NOT EXISTS
	`users` (
			id int(11) NOT NULL AUTO_INCREMENT,
			username varchar(255),
			passhash varchar(255),
			first_name varchar(255),
			last_name varchar(255),
			email varchar(255),
			oauth_provider varchar(64),
			oauth_id varchar(50),
			created datetime NOT NULL,
			modified datetime NOT NULL,
			PRIMARY KEY(id)
		);";
$mysql->query($sql);


$sql = "CREATE TABLE IF NOT EXISTS
	`categories` (
			id int(11) NOT NULL AUTO_INCREMENT,
			name varchar(255),
			primary key(id)
	);";
$mysql->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS
	`items` ( 
			id int(11) NOT NULL AUTO_INCREMENT,
			category_id int(11) NOT NULL,
			name varchar(255),
			PRIMARY KEY(id),
			INDEX idxCat (category_id),
			CONSTRAINT fkCat FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
			
		);";
$mysql->query($sql);


