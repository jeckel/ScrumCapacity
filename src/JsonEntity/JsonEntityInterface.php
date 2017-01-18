<?php
/**
 * Created by PhpStorm.
 * User: jmercier
 * Date: 18/01/17
 * Time: 09:02
 */

namespace Jeckel\Scrum\JsonEntity;

/**
 * Interface JsonEntityInterface
 * @package Jeckel\Scrum\JsonEntity
 */
interface JsonEntityInterface
{
    /**
     * @return array
     */
    public function getJsonArray(): array;
}