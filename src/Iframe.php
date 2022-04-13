<?php

namespace Surface\CommonMark\Ext\YouTubeIframe;

use League\CommonMark\Node\Inline\AbstractInline;
use Surface\CommonMark\Ext\YouTubeIframe\Url\Contracts\Url;

final class Iframe extends AbstractInline
{
    public function __construct(protected Url $url)
    {
        $this->url = $url;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }
}
