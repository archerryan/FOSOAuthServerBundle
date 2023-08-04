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

namespace FOS\OAuthServerBundle\Model;

use FOS\OAuthServerBundle\Util\Random;
use OAuth2\OAuth2;

class Client implements ClientInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $randomId;

    /**
     * @var string
     */
    protected $secret;

    /**
     * @var array
     */
    protected $redirectUris = [];

    /**
     * @var array
     */
    protected $allowedGrantTypes = [];

    public function __construct()
    {
        $this->allowedGrantTypes[] = OAuth2::GRANT_TYPE_AUTH_CODE;

        $this->setRandomId(Random::generateToken());
        $this->setSecret(Random::generateToken());
    }

    public function getId()
    {
        return $this->id;
    }

    public function setRandomId($random)
    {
        $this->randomId = $random;
    }

    public function getRandomId()
    {
        return $this->randomId;
    }

    public function getPublicId(): string
    {
        return sprintf('%s_%s', $this->getId(), $this->getRandomId());
    }

    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    public function getSecret()
    {
        return $this->secret;
    }

    public function checkSecret($secret)
    {
        return null === $this->secret || $secret === $this->secret;
    }

    public function setRedirectUris(array $redirectUris)
    {
        $this->redirectUris = $redirectUris;
    }

    public function getRedirectUris(): array
    {
        return $this->redirectUris;
    }

    public function setAllowedGrantTypes(array $grantTypes)
    {
        $this->allowedGrantTypes = $grantTypes;
    }

    public function getAllowedGrantTypes()
    {
        return $this->allowedGrantTypes;
    }
}
