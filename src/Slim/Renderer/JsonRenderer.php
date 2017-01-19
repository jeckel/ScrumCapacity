<?php
/**
 * User: Julien MERCIER <jeckel@jeckel.fr>
 * Date: 17/01/17
 * Time: 22:54
 */
namespace Jeckel\Scrum\Slim\Renderer;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Uri;

/**
 * Class JsonRenderer
 * @package Jeckel\Scrum\Slim\Renderer
 */
class JsonRenderer
{
    /**
     * @var array
     */
    protected $links = [];

    /**
     * @var Uri
     */
    protected $uri;

    /**
     * @param ResponseInterface $response
     * @param $data
     * @return ResponseInterface
     */
    public function render(ResponseInterface $response, $data): ResponseInterface
    {
        $json = [];
        if (! empty($this->links)) {
            $json['links'] = $this->links;
        }
        $json['data'] = $data;

        return $response->withJson($json);
    }

    /**
     * @param string $key
     * @param string $link
     * @return JsonRenderer
     */
    public function addLink(string $key, string $link): JsonRenderer
    {
        if ($link[0] == '/') {
            $prefix = $this->uri->getScheme() . '://' . $this->uri->getHost();
            $this->links[$key] = $prefix . $link;
        } else {
            $this->links[$key] = $link;
        }
        return $this;
    }

    /**
     * @param Uri $uri
     */
    public function setUri(Uri $uri)
    {
        $this->uri = $uri;
    }
}
