<?php

namespace Surface\CommonMark\Ext\YouTubeIframe\Url\Contracts;

interface Url
{
    public function getType(): string;

    public function getUuid(): string;

    public function getWidth(): int;

    public function getHeight(): int;

    public function getTimestamp(): ?int;
}
