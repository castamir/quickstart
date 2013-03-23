<?php

use Nette\Security, Nette\Utils\Strings;

/**
 * Users authenticator.
 */
class Authenticator extends Nette\Object implements Security\IAuthenticator
{

	/** @var Todo\UserRepository */
	private $userRepository;

	/**
	 * @param Todo\UserRepository $userRepository
	 */
	public function __construct(Todo\UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	/**
	 * Performs an authentication.
	 *
	 * @param array $credentials
	 * @throws Nette\Security\AuthenticationException
	 * @return Nette\Security\Identity
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;
		$row = $this->userRepository->findByName($username);

		if (!$row) {
			throw new Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);
		}

		if ($row->password !== $this->calculateHash($password, $row->password)) {
			throw new Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);
		}

		unset($row->password);

		return new Security\Identity($row->id, NULL, $row->toArray());
	}

	/**
	 * Computes salted password hash.
	 *
	 * @param  string $password
	 * @param  string $salt
	 * @return string
	 */
	public static function calculateHash($password, $salt = NULL)
	{
		if ($salt === NULL) {
			$salt = '$2a$07$' . Nette\Utils\Strings::random(32) . '$';
		}

		return crypt($password, $salt);
	}

}
