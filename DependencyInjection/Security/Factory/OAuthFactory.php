<?php

declare(strict_types=1);

/*
 * This file is part of the FOSOAuthServerBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\OAuthServerBundle\DependencyInjection\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AuthenticatorFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * OAuthFactory class.
 *
 * @author Arnaud Le Blanc <arnaud.lb@gmail.com>
 */
class OAuthFactory implements AuthenticatorFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createAuthenticator(ContainerBuilder $container, string $id, array $config, string $userProviderId)
    {
        $providerId = 'fos_oauth_server.security.authentication.authenticator.'.$id;
        $container
            ->setDefinition($providerId, new ChildDefinition('fos_oauth_server.security.authentication.authenticator'))
            ->replaceArgument(0, new Reference('fos_oauth_server.server'))
            ->replaceArgument(1, new Reference('security.user_checker.'.$id))
            ->replaceArgument(2, new Reference($userProviderId))
        ;

        return $providerId;
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority(): int
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getKey(): string
    {
        return 'fos_oauth';
    }

    /**
     * {@inheritdoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
    }
}
