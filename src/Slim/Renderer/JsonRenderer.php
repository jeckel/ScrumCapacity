<?php
/**
 * Created by PhpStorm.
 * User: jeckel
 * Date: 17/01/17
 * Time: 22:54
 */

namespace Jeckel\Scrum\Slim\Renderer;


use Psr\Http\Message\ResponseInterface;

class JsonRenderer
{
    protected $links = [];

    public function render(ResponseInterface $response, array $data = []): ResponseInterface
    {
        $json = [];
        if (! empty($this->links)) {
            $json['links'] = $this->links;
        }
        $json['data'] = $data;

        return $response->withJson($json);
    }

    public function setLink(string $key, string $link): JsonRenderer
    {
        $this->links[$key] = $link;
        return $this;
    }
}
