<?php
/**
 * User: Julien MERCIER <jeckel@jeckel.fr>
 * Date: 19/01/17
 * Time: 11:49
 */

namespace Jeckel\Scrum\Controller;


use Jeckel\Scrum\Slim\Renderer\JsonRenderer;

/**
 * Class AbstractController
 * @package Jeckel\Scrum\Controller
 */
class AbstractController
{
    /**
     * @var JsonRenderer
     */
    protected $renderer;

    /**
     * @param JsonRenderer $renderer
     * @return AbstractController
     */
    public function setRenderer(JsonRenderer $renderer): self
    {
        $this->renderer = $renderer;
        return $this;
    }
}
