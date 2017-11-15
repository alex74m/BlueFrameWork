<?php

namespace App\Model;

/**
* @user entity
*/
class User
{
	private $id;
	private $name;
	private $age;

	public function getId()
	{
		return $this->id;
	}
	public function getName()
	{
		return $this->name;
	}
	public function getAge()
	{
		return $this->age;
	}
	public function setId($id)
	{
		$this->id = $id;
	}
	public function setName($name)
	{
		$this->name = $name;
	}
	public function setAge($age)
	{
		$this->age = $age;
	}
}