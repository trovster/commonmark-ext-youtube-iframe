<?php

namespace Surface\CommonMark\Ext\YouTubeIframe\Url;

use Surface\CommonMark\Ext\YouTubeIframe\Url\Contracts\Url as Contract;

final class Url implements Contract
{
    protected string $type;
    protected string $uuid;
    protected ?int $width;
    protected ?int $height;
    protected ?int $timestamp;

    public function __construct(string $type, string $uuid, ?int $width, ?int $height, ?int $timestamp)
    {
        $this->type = $type;
        $this->uuid = $uuid;
        $this->width = $width;
        $this->height = $height;
        $this->timestamp = $timestamp;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getWidth(): int
    {
        return $this->width ?? 800;
    }

    public function getHeight(): int
    {
        return $this->height ?? 600;
    }

    public function getTimestamp(): ?int
    {
        return $this->timestamp;
    }
}
