<?php

namespace Surface\CommonMark\Ext\YouTubeIframe\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function widthProvider(): iterable
    {
        return [
            yield [100, 100],
            yield ['', 800],
            yield ['x', 800],
        ];
    }

    public function heightProvider(): iterable
    {
        return [
            yield [100, 100],
            yield ['', 600],
            yield ['x', 600],
        ];
    }

    public function timestampProvider(): iterable
    {
        return [
            yield [100, 100],
            yield ['', null],
            yield ['x', null],
        ];
    }

    protected function getHtml(string $url, int $width = 800, int $height = 600): string
    {
        return '<iframe width="' . $width . '" height="' . $height . '" src="' . $url . '" frameborder="0" allowfullscreen="1" allow="autoplay; fullscreen; picture-in-picture"></iframe>';
    }
}
