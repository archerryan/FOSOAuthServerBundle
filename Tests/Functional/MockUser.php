<?php

declare(strict_types=1);

namespace FOS\OAuthServerBundle\Tests\Functional;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

abstract class MockUser implements UserInterface, PasswordAuthenticatedUserInterface
{
}
