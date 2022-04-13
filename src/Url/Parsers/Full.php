<?php

namespace Surface\CommonMark\Ext\YouTubeIframe\Url\Parsers;

use Surface\CommonMark\Ext\YouTubeIframe\Url\Contracts\Parser as Contract;
use Surface\CommonMark\Ext\YouTubeIframe\Url\Parser;
use Surface\CommonMark\Ext\YouTubeIframe\Url\Url;

final class Full extends Parser implements Contract
{
    protected string $host = 'www.youtube.com';
    protected string $path = '/watch';

    public function parse(string $url): ?Url
    {
        $path = parse_url($url, PHP_URL_PATH);

        if ($path !== $this->path) {
            return null;
        }

        return parent::parse($url);
    }

    protected function getUuid(string $url): ?string
    {
        $key = 'v';

        parse_str((string) parse_url($url, PHP_URL_QUERY), $params);

        if (array_key_exists($key, $params) && '' !== $params[$key]) {
            return $params[$key];
        }

        return null;
    }
}
