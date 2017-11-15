<?php

namespace App\Controller;
use \PDO;

/**
* @Database
*/
class Database
{
	private static $db;

	private function __construct()
	{
		self::$db = new PDO('mysql:host=localhost;dbname=test_alex_poo','root','root');
	}

	public static function getInstance()
	{
		if (is_null(self::$db)) {
			new self;
		}
		return self::$db;
	}
}