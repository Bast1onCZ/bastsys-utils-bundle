<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Security;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

/**
 * Class PasswordEncoder
 * @package BastSys\UtilsBundle\Security
 * @author mirkl
 */
class PasswordEncoder implements PasswordEncoderInterface {
	/**
	 * @param string      $raw
	 * @param string|null $salt
	 *
	 * @return bool|string
	 */
    public function encodePassword(string $raw, ?string $salt) {
        return password_hash($raw, PASSWORD_BCRYPT);
    }

	/**
	 * @param string      $encoded
	 * @param string      $raw
	 * @param string|null $salt
	 *
	 * @return bool
	 */
    public function isPasswordValid(string $encoded, string $raw, ?string $salt) {
        return password_verify($raw, $encoded);
    }

    /**
     * @param string $encoded
     * @return bool
     */
    public function needsRehash(string $encoded): bool
    {
        return false;
    }
}
