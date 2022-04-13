<?php

namespace Surface\CommonMark\Ext\YouTubeIframe;

use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Inline\Element\Link;
use Surface\CommonMark\Ext\YouTubeIframe\Iframe;
use Surface\CommonMark\Ext\YouTubeIframe\Url\Contracts\Parser;
use TypeError;

final class Processor
{
    protected array $parsers;

    public function __construct(array $parsers)
    {
        foreach ($parsers as $parser) {
            if (! ($parser instanceof Parser)) {
                throw new TypeError();
            }
        }

        $this->parsers = $parsers;
    }

    protected function parse(Link $link): void
    {
        foreach ($this->parsers as $parser) {
            $url = $parser->parse($link->getUrl());

            if (null === $url) {
                continue;
            }

            $link->replaceWith(
                new Iframe($url)
            );
        }
    }

    public function __invoke(DocumentParsedEvent $event): void
    {
        $walker = $event->getDocument()->walker();

        while ($item = $walker->next()) {
            if (! ($item->getNode() instanceof Link)) {
                continue;
            }

            if ($item->isEntering()) {
                continue;
            }

            $link = $item->getNode();

            if (! ($link instanceof Link)) {
                continue;
            }

            $this->parse($link);
        }
    }
}
