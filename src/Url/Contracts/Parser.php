<?php

namespace Surface\CommonMark\Ext\YouTubeIframe\Url\Contracts;

use Surface\CommonMark\Ext\YouTubeIframe\Url\Contracts\Url;

interface Parser
{
    public function parse(string $url): ?Url;

    public function getType(): string;
}
