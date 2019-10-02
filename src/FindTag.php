<?php

namespace Arquivei\XML\Tag\Finder;

use Arquivei\XML\Tag\Finder\Adapters\XmlParserInterface;
use Arquivei\XML\Tag\Finder\Entities\Tag;

class FindTag extends Finder
{
    private $xml;
    private $parserAdapter;
    private $xmlTreeNode;

    public function __construct(
        string $xml,
        XmlParserInterface $parserAdapter
    ) {
        parent::__construct($xml, $parserAdapter);
        $this->parserAdapter = $parserAdapter;
        $this->xml = $xml;
    }

    public function find(string $tags)
    {
        $this->xmlTreeNode = $this->parserAdapter->parse($this->xml);
        $tagsArray = explode('/', $tags);
        foreach ($tagsArray as $value) {
            $this->xmlTreeNode = $this->xmlTreeNode->getChildByName($value);

        }
        return $this;
    }

    public function getTag(string $tags)
    {
        $this->find($tags);
        return (new Tag())
            ->setKey($tags)
            ->setValue($this->xmlTreeNode->getContent());
    }
}
