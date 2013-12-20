<?php

namespace li3_nzedb\models;

class Users extends \lithium\data\Model
{
	public function fullName($entity)
	{
		return $entity->firstName . ' ' . $entity->lastName;
	}
}

?>
