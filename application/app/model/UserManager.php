<?php

namespace App\Model;

use \Nette,
    \Nette\Utils\Strings,
    \Nette\Security\Passwords;

/**
 * Users management.
 */
class UserManager extends Nette\Object implements Nette\Security\IAuthenticator {

    const
            TABLE_NAME = 'user',
            COLUMN_ID = 'id',
            COLUMN_NAME = 'username',
            COLUMN_PASSWORD_HASH = 'password',
            COLUMN_ROLE = 'role';

    /** @var Nette\Database\Context */
    private $database;

    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }

    /**
     * Performs an authentication.
     * @return Nette\Security\Identity
     * @throws Nette\Security\AuthenticationException
     */
    public function authenticate(array $credentials) {
        list($username, $password) = $credentials;

        $row = $this->database->table(self::TABLE_NAME)->where(self::COLUMN_NAME, $username)->fetch();

        if (!$row) {
            throw new Nette\Security\AuthenticationException('Neplatné uživatelské jméno.', self::IDENTITY_NOT_FOUND);
        } elseif (!UserManager\Passwords::verify($password, $row[self::COLUMN_PASSWORD_HASH])) {
            throw new Nette\Security\AuthenticationException('Neplatné heslo.', self::INVALID_CREDENTIAL);
        } elseif (UserManager\Passwords::needsRehash($row[self::COLUMN_PASSWORD_HASH])) {
            $row->update(array(
                self::COLUMN_PASSWORD_HASH => UserManager\Passwords::hash($password),
            ));
        }

        $arr = $row->toArray();
        unset($arr[self::COLUMN_PASSWORD_HASH]);
        return new Nette\Security\Identity($row[self::COLUMN_ID], $row[self::COLUMN_ROLE], $arr);
    }

    /**
     * Adds new user.
     * @param  string
     * @param  string
     * @return void
     */
    public function add($username, $password) {
        try {
            $this->database->table(self::TABLE_NAME)->insert(array(
                self::COLUMN_NAME => $username,
                self::COLUMN_PASSWORD_HASH => UserManager\Passwords::hash($password),
            ));
        } catch (Nette\Database\UniqueConstraintViolationException $e) {
            throw new DuplicateNameException;
        }
    }

    /**
     * Changes user password.
     * @param  string
     * @param  string
     * @return void
     */
    public function changePassword($username, $password) {
        try {
            $this->database->table(self::TABLE_NAME)->update(array(
                self::COLUMN_NAME => $username,
                self::COLUMN_PASSWORD_HASH => UserManager\Passwords::hash($password),
            ));
        } catch (\Exception $e) {
            throw new UserNotFoundException;
        }
    }

}

class DuplicateNameException extends \Exception {
    
}

namespace App\Model\UserManager;

class Passwords {

    public static function hash($password, $salt = NULL) {
        if (PHP_VERSION_ID < 50307) {
            return crypt($password, $salt ?: '$2a$07$' . \Nette\Utils\Strings::random(22));
        } else {
            return \Nette\Security\Passwords::hash($password);
        }
    }
    
    public static function verify($password, $hash) {
        if (PHP_VERSION_ID < 50307) {
            return self::hash($password, $hash) == $hash;
        } else {
            return \Nette\Security\Passwords::verify($password, $hash);
        }
    }
    
    public static function needsRehash($password, array $options = NULL) {
        if (PHP_VERSION_ID < 50307) {
            return false;
        } else {
            return \Nette\Security\Passwords::needsRehash($password, $options);
        }
    }

}
