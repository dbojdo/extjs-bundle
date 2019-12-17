<?php

namespace Webit\Bundle\ExtJsBundle\StaticData;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

final class SecurityContextExposer
{

    private $serializer;

    /** @var TokenStorageInterface */
    private $tokenStorage;

    /** @var RoleHierarchyInterface */
    private $roleHierarchy;

    /** @var array */
    private $securityConfig;

    public function __construct(TokenStorageInterface $tokenStorage, RoleHierarchyInterface $roleHierarchy, array $securityConfig)
    {
        $this->tokenStorage = $tokenStorage;
        $this->roleHierarchy = $roleHierarchy;
        $this->securityConfig = $securityConfig;
    }

    public function expose()
    {
        $user = null;
        $token = $this->tokenStorage->getToken();
        if ($token) {
            $user = $token->getUser();
            $user = $user != 'anon.' ? $user : null;
        }

        if ($user) {
            $user = clone($user);

            $arRoles = $user->getRoles();
            foreach ($arRoles as &$role) {
                $role = new Role($role);
            }

            $arRoles = $this->roleHierarchy->getReachableRoles($arRoles);
            foreach ($arRoles as &$role) {
                $role = $role->getRole();
            }
            $user->setRoles($arRoles);
        }

        return array(
            'user' => $user,
            'model' => $this->securityConfig['model']
        );
    }

}