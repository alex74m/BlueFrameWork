<?php

namespace App\Form;


class FormType
{
	private $inputList = array();
	private static $tokenValue;

	public function __construct()
	{
		self::$tokenValue = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
	}

	public function setInputList($field = [])
	{
		foreach ($field as $key => $value) {
			if (in_array($value['type'], ['text','password'])) {
				$this->inputList[] = '<input type="'.$value['type'].'" name="'.$value['name'].'" placeholder="'.$value['placeholder'].'" value="'.$value['value'].'" required="'.$value['required'].'" class="'.$value['class'].'" id="'.$value['id'].'"><br>';
			}
			if (in_array($value['type'], ['textarea'])) {
				$this->inputList[] = '<textarea name="'.$value['name'].'" required="'.$value['required'].'" class="'.$value['class'].'" id="'.$value['id'].'" placeholder="'.$value['placeholder'].'"></textarea><br>';
			}
		}		
		$this->inputList[] = '<input type="hidden" name="_token" value="'.self::$tokenValue.'"><br>';
		return;
	}

	public function getInputList(){return $this->inputList;}
	public function getTokenValue(){return self::$tokenValue;}

}