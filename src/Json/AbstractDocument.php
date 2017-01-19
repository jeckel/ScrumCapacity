<?php
/**
 * User: Julien MERCIER <jeckel@jeckel.fr>
 * Date: 19/01/17
 * Time: 17:23
 */

namespace Jeckel\Scrum\Json;


use Jeckel\Scrum\Json\Exception\RuntimeException;

abstract class AbstractDocument implements JsonElementInterface
{
    protected $data;

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var Meta
     */
    protected $meta;

    /**
     * @var Links
     */
    protected $links;

    /**
     * @todo replace with the real object
     * @var JsonElementInterface
     */
    protected $jsonapi;

    /**
     * @var array
     */
    protected $included = [];

    /**
     * @param Links|array $links
     * @return self
     */
    public function setLinks($links): self
    {
        if ($links instanceof Links) {
            $this->links = $links;
        } else {
            if (empty($this->links)) {
                $this->links = new Attributes($links);
            } else {
                // @todo
            }
        }
        return $this;
    }

    /**
     * @return Links
     */
    public function getLinks(): Links
    {
        if (empty($this->links)) {
            $this->links = new Links();
        }
        return $this->links;
    }

    /**
     * @return array
     * @throws RuntimeException
     */
    public function jsonSerialize(): array
    {
        if (! $this->isValid()) {
            throw new RuntimeException("Can not export not valid element");
        }
        $toReturn = [];
        if (! empty($this->data)) {
            $toReturn['data'] = $this->jsonSerializeData();
        }
        if (! empty($links = $this->links->jsonSerialize())) {
            $toReturn['links'] = $links;
        }
        // @todo : to be completed
        return $toReturn;
    }

    /**
     * @return array
     */
    abstract protected function jsonSerializeData(): array;

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        if (empty($this->data) && empty($this->errors) && empty($this->meta)) {
            return false;
        }
        if (empty($this->data) && !empty($this->included)) {
            return false;
        }
        return true;
    }
}
