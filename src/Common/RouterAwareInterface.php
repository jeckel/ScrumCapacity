<?php
/**
 * User: Julien MERCIER <jeckel@jeckel.fr>
 * Date: 19/01/17
 * Time: 11:20
 */

namespace Jeckel\Scrum\Common;

use Slim\Interfaces\RouterInterface;

/**
 * Interface RouterAwareInterface
 * @package Jeckel\Scrum\Common
 */
interface RouterAwareInterface
{
    /**
     * @param RouterInterface $router
     * @return RouterAwareInterface
     */
    public function setRouter(RouterInterface $router): self;
}
