<?php
/**
 * User: Julien MERCIER <jeckel@jeckel.fr>
 * Date: 23/01/17
 * Time: 13:44
 */

namespace Jeckel\Scrum\Model;


trait JsonableTrait
{
    public function getJsonId(): string
    {
        return (string) $this->{$this->primaryKey};
    }

    public function getJsonType(): string
    {
        return strtolower($this->table);
    }

    public function getJsonAttributes(): array
    {
        $data = $this->toArray();
        unset($data[$this->primaryKey]);
        return $data;
    }
}
