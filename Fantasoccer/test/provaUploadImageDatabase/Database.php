<?php


class Database {

	protected static $instance;

	protected function __construct() {
    }

	public static function getConnection() {

		if(empty(self::$instance)) {
			$config=parse_ini_file("config/conf.ini");
			try {
				self::$instance = new PDO("mysql:host=".$config['db_host'].';port='.$config['db_port'].';dbname='.$config['db_name'], $config['db_user'], $config['db_pass']);
				self::$instance->setAttribute(PDO::ATTR_PERSISTENT, true);  
				self::$instance->query('SET NAMES utf8');
				self::$instance->query('SET CHARACTER SET utf8');

			} catch(PDOException $error) {
				echo $error->getMessage();
			}
		}
		return self::$instance;
	}

}
  

?>

