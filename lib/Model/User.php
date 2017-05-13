<?php

namespace LinkORB\BasicUser\Model;

use Symfony\Component\Security\Core\User\User as AdvancedUser;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * User which decorates Symfony's in-memory User.
 */
class User implements AdvancedUserInterface
{
    /**
     * @var string
     */
    private $displayName;
    /**
     * @var \Symfony\Component\Security\Core\User\User
     */
    private $user;

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function __construct(AdvancedUser $user)
    {
        $this->user = $user;
    }

    public function getRoles()
    {
        return $this->user->getRoles();
    }

    public function getPassword()
    {
        return $this->user->getPassword();
    }

    public function getSalt()
    {
        return $this->user->getSalt();
    }

    public function getUsername()
    {
        return $this->user->getUsername();
    }

    public function isAccountNonExpired()
    {
        return $this->user->isAccountNonExpired();
    }

    public function isAccountNonLocked()
    {
        return $this->user->isAccountNonLocked();
    }

    public function isCredentialsNonExpired()
    {
        return $this->user->isCredentialsNonExpired();
    }

    public function isEnabled()
    {
        return $this->user->isEnabled();
    }

    public function eraseCredentials()
    {
        return $this->user->eraseCredentials();
    }
}
