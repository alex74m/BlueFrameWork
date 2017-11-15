<?php

namespace App\Controller;

use \App\Model\User;

/**
* @Manager/Controller
*/
class Controller
{
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}
	public function getDb(){return $this->db;}
	
	public function queryUsers()
	{
		$req = $this->getDb()->query('SELECT * FROM user');
	
		$users = [];
		while ($data = $req->fetch()) {
			$user = new User(
				$data['id'],
				$data['name'],
				$data['age'])
			;
			$users[] = $user;
		}
		return $users;
	}

	public function newUser(User $user)
	{
		$req = $this->getDb()->prepare('INSERT INTO user (name,age) VALUES (:name,:age)');
		$req->execute(array(
			':name' => $user->getName(),
			':age' => $user->getAge()
		));
	}
}