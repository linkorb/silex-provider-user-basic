<?php

namespace LinkORB\BasicUser\Provider;

use Symfony\Component\Security\Core\User\User as AdvancedUser;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

use LinkORB\BasicUser\Model\User;

class UserProvider implements UserProviderInterface
{
    private $users;

    public function __construct(array $users)
    {
        $this->users = $users;
    }

    public function loadUserByUsername($username)
    {
        if (!array_key_exists($username, $this->users)
            || !array_key_exists('password', $this->users[$username])
        ) {
            throw new UsernameNotFoundException("User \"{$username}\" could not be found or does not have a password.");
        }

        $password = $this->users[$username]['password'];

        $roles = ['user'];
        if (array_key_exists('roles', $this->users[$username])) {
            $roles = $this->users[$username]['roles'];
        }

        $enabled = true;
        if (array_key_exists('enabled', $this->users[$username])) {
            $enabled = (bool) $this->users[$username]['enabled'];
        }

        $displayName = $username;
        if (array_key_exists('display_name', $this->users[$username])) {
            $displayName = $this->users[$username]['display_name'];
        }

        $user = new User(
            new AdvancedUser($username, $password, $roles, $enabled, true, true, true)
        );
        $user->setDisplayName($displayName);

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'Symfony\Component\Security\Core\User\User';
    }
}
