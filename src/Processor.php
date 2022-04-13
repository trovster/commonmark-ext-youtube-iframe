<?php

namespace Surface\CommonMark\Ext\YouTubeIframe;

use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use Surface\CommonMark\Ext\YouTubeIframe\Iframe;
use Surface\CommonMark\Ext\YouTubeIframe\Url\Contracts\Parser;
use TypeError;

final class Processor
{
    public function __construct(protected array $parsers)
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
            $link = $item->getNode();

            if (! ($link instanceof Link)) {
                continue;
            }

            $this->parse($link);
        }
    }
}
