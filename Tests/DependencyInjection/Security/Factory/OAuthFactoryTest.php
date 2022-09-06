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

namespace FOS\OAuthServerBundle\Tests\DependencyInjection\Security\Factory;

use FOS\OAuthServerBundle\DependencyInjection\Security\Factory\OAuthFactory;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class OAuthFactoryTest.
 *
 * @author Nikola Petkanski <nikola@petkanski.com>
 */
class OAuthFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var OAuthFactory
     */
    protected $instance;

    public function setUp(): void
    {
        $this->instance = new OAuthFactory();

        parent::setUp();
    }

    public function testGetKey(): void
    {
        $this->assertSame('fos_oauth', $this->instance->getKey());
    }

    public function testCreateAuthenticator(): void
    {
        $container = $this->getMockBuilder(ContainerBuilder::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'setDefinition',
            ])
            ->getMock()
        ;
        $id = '12';
        $config = [];
        $userProviderId = 'mock.user.provider.service';

        $definition = $this->getMockBuilder(Definition::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $container
            ->expects($this->once())
            ->method('setDefinition')
            ->with(
                'fos_oauth_server.security.authentication.authenticator.'.$id,
                new ChildDefinition('fos_oauth_server.security.authentication.authenticator')
            )
            ->will($this->returnValue($definition))
        ;

        $definition
            ->expects($this->exactly(3))
            ->method('replaceArgument')
            ->withConsecutive(
                [
                    0,
                    new Reference('fos_oauth_server.server'),
                ],
                [
                    1,
                    new Reference('security.user_checker.'.$id),
                ],
                [
                    2,
                    new Reference($userProviderId),
                ]
            )
            ->willReturnOnConsecutiveCalls(
                $definition,
                $definition,
                $definition
            )
        ;

        $this->assertSame(
            'fos_oauth_server.security.authentication.authenticator.'.$id,
            $this->instance->createAuthenticator($container, $id, $config, $userProviderId)
        );
    }

    public function testAddConfigurationDoesNothing(): void
    {
        $nodeDefinition = $this->getMockBuilder(NodeDefinition::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->assertNull($this->instance->addConfiguration($nodeDefinition));
    }
}
