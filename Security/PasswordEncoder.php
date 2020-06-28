<?php

namespace BastSys\UtilsBundle\Security;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

/**
 * Class PasswordEncoder
 * @package App\ResourceBundle\Security
 * @author mirkl
 */
class PasswordEncoder implements PasswordEncoderInterface {
    /**
     * @param string      $raw
     * @param string|null $salt
     *
     * @return bool|string
     */
    public function encodePassword($raw, $salt) {
        return password_hash($raw, PASSWORD_BCRYPT);
    }

    /**
     * @param string      $encoded
     * @param string      $raw
     * @param string|null $salt
     *
     * @return bool
     */
    public function isPasswordValid($encoded, $raw, $salt) {
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
