<?php
/**
 * User: Julien MERCIER <jeckel@jeckel.fr>
 * Date: 23/01/17
 * Time: 13:41
 */

namespace Jeckel\Scrum\Model;


interface JsonableInterface
{
    public function getJsonId(): string;

    public function getJsonType(): string;

    public function getJsonAttributes(): array;
}
