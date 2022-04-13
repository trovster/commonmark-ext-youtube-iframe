<?php

namespace Surface\CommonMark\Ext\YouTubeIframe\Url;

use Surface\CommonMark\Ext\YouTubeIframe\Url\Contracts\Parser as Contract;
use Surface\CommonMark\Ext\YouTubeIframe\Url\Url;

abstract class Parser implements Contract
{
    protected string $host = '';
    protected string $type;
    protected int $defaultWidth;
    protected int $defaultHeight;

    abstract protected function getUuid(string $url): ?string;

    public function __construct(int $defaultWidth = 800, int $defaultHeight = 600)
    {
        $this->setType();
        $this->defaultWidth = $defaultWidth;
        $this->defaultHeight = $defaultHeight;
    }

    public function parse(string $url): ?Url
    {
        $host = parse_url($url, PHP_URL_HOST);

        if ($host !== $this->host) {
            return null;
        }

        $uuid = $this->getUuid($url);
        $width = $this->getWidth($url);
        $height = $this->getHeight($url);
        $timestamp = $this->getTimestamp($url);

        if (null === $uuid) {
            return null;
        }

        return new Url($this->type, $uuid, $width, $height, $timestamp);
    }

    public function getType(): string
    {
        return $this->type;
    }

    protected function getTimestamp(string $url): ?int
    {
        $key = 't';
        $params = $this->getQueryParams($url);

        if (array_key_exists($key, $params) && '' !== $params[$key] && is_numeric($params[$key])) {
            return (int) $params[$key];
        }

        return null;
    }

    protected function getHeight(string $url): int
    {
        $key = 'height';
        $params = $this->getQueryParams($url);

        if (array_key_exists($key, $params) && '' !== $params[$key] && is_numeric($params[$key])) {
            return (int) $params[$key];
        }

        return $this->defaultHeight;
    }

    protected function getWidth(string $url): int
    {
        $key = 'width';
        $params = $this->getQueryParams($url);

        if (array_key_exists($key, $params) && '' !== $params[$key] && is_numeric($params[$key])) {
            return (int) $params[$key];
        }

        return $this->defaultWidth;
    }

    protected function getQueryParams(string $url): array
    {
        parse_str((string) parse_url($url, PHP_URL_QUERY), $params);

        return $params;
    }

    protected function setType(): self
    {
        if (! isset($this->type)) {
            $paths = explode('\\', static::class);
            $className = array_pop($paths);

            $this->type = strtolower($className);
        }

        return $this;
    }
}
