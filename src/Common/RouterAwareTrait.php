<?php
/**
 * User: Julien MERCIER <jeckel@jeckel.fr>
 * Date: 19/01/17
 * Time: 11:21
 */

namespace Jeckel\Scrum\Common;

use Slim\Interfaces\RouterInterface;

/**
 * Class RouterAwareTrait
 * @package Jeckel\Scrum\Common
 */
trait RouterAwareTrait
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @param RouterInterface $router
     * @return RouterAwareInterface
     */
    public function setRouter(RouterInterface $router): RouterAwareInterface
    {
        $this->router = $router;
        /** @var RouterAwareInterface $this */
        return $this;
    }

    public function getRouter(): RouterInterface
    {
        return $this->router;
    }
}
