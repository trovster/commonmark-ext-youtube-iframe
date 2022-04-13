<?php

namespace Surface\CommonMark\Ext\YouTubeIframe\Url\Parsers;

use Surface\CommonMark\Ext\YouTubeIframe\Url\Contracts\Parser as Contract;
use Surface\CommonMark\Ext\YouTubeIframe\Url\Parser;

final class Short extends Parser implements Contract
{
    protected string $host = 'youtu.be';

    protected function getUuid(string $url): ?string
    {
        $uuid = substr((string) parse_url($url, PHP_URL_PATH), 1);

        if ('' === $uuid) {
            return null;
        }

        return $uuid;
    }
}
