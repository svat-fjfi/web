<?php

namespace App\Security;

/**
 * Description of Passwords
 *
 * @author František Blachowicz <f.blach@owi.cz>
 *         Created on 27.4.2015
 * 
 */
class Passwords extends \Nette\Security\Passwords {
    /**
    * Computes salted password hash.
    * @param  string
    * @param  array with cost (4-31), salt (22 chars)
    * @return string  60 chars long
    */
   public static function hash($password, array $options = NULL)
   {
            $cost = isset($options['cost']) ? (int) $options['cost'] : self::BCRYPT_COST;
            $salt = isset($options['salt']) ? (string) $options['salt'] : Nette\Utils\Random::generate(22, '0-9A-Za-z./');

            if (PHP_VERSION_ID < 50307) {
                    throw new Nette\NotSupportedException(__METHOD__ . ' requires PHP >= 5.3.7.');
            } elseif (($len = strlen($salt)) < 22) {
                    throw new Nette\InvalidArgumentException("Salt must be 22 characters long, $len given.");
            } elseif ($cost < 4 || $cost > 31) {
                    throw new Nette\InvalidArgumentException("Cost must be in range 4-31, $cost given.");
            }

            if (PHP_VERSION_ID < 50307) {
                $hash = crypt($password, '$6$rounds=5000$' . $salt);
            }
            else {
                $hash = crypt($password, '$2y$' . ($cost < 10 ? 0 : '') . $cost . '$' . $salt);
            }
                 
            if (strlen($hash) < 60) {
                throw new Nette\InvalidStateException('Hash returned by crypt is invalid.');
            }
            return $hash;
   }
}
