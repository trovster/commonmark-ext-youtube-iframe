<?php

namespace Surface\CommonMark\Ext\YouTubeIframe\Url;

use Surface\CommonMark\Ext\YouTubeIframe\Url\Contracts\Url as Contract;

final class Url implements Contract
{
    public function __construct(
        protected string $type,
        protected string $uuid,
        protected ?int $width,
        protected ?int $height,
        protected ?int $timestamp
    ) {
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
