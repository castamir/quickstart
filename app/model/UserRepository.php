<?php
namespace Todo;

use Nette;

/**
 * Tabulka user
 */
class UserRepository extends Repository
{

	public function findByName($username)
	{
		return $this->findAll()->where('username', $username)->fetch();
	}
}
