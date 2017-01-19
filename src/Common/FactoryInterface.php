<?php
/**
 * User: Julien MERCIER <jeckel@jeckel.fr>
 * Date: 18/01/17
 * Time: 13:56
 */

namespace Jeckel\Scrum\Common;

use Slim\Container;

/**
 * Interface FactoryInterface
 * @package Jeckel\Scrum\Common
 */
interface FactoryInterface
{
    /**
     * @param Container $c
     * @return mixed
     */
    public function __invoke(Container $c);
}
