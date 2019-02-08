<?php

namespace App\Service\Encoder;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

/**
 * Class PasswordEncoder
 * @package App\Service
 */
class PasswordEncoder implements PasswordEncoderInterface
{
    /**
     * @param string $raw
     * @param string $salt
     * @return string
     */
    public function encodePassword($raw, $salt)
    {
        $salted = $salt . ':' . $raw;
        $hash = hash('sha1', $salted);

        return $hash;
    }

    /**
     * @param string $encoded
     * @param string $raw
     * @param string $salt
     * @return bool
     */
    public function isPasswordValid($encoded, $raw, $salt)
    {
        $isValid = $encoded === $this->encodePassword($raw, $salt);

        return $isValid;
    }

}