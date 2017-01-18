<?php
/**
 * Created by PhpStorm.
 * User: jmercier
 * Date: 18/01/17
 * Time: 08:59
 */

namespace Jeckel\Scrum\JsonEntity;

/**
 * Class AbstractEntity
 * @package Jeckel\Scrum\JsonEntity
 */
abstract class AbstractEntity implements JsonEntityInterface
{
    /**
     * @return array
     */
    protected function getData(): array
    {
        return [];
    }

    /**
     * @return array
     */
    protected function getLinks(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getJsonArray(): array
    {
        $to_return = [];
        if (! empty($links = $this->getLinks())) {
            $to_return['links'] = $links;
        }
        if (! empty($data = $this->getData())) {
            $to_return['data'] = $data;
        }
        return $to_return;
    }
}
