<?php

namespace Surface\CommonMark\Ext\YouTubeIframe\Tests;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Surface\CommonMark\Ext\YouTubeIframe\Extension;

abstract class TestCase extends BaseTestCase
{
    protected MarkdownConverter $converter;

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
        return '<iframe width="' . $width . '" height="' . $height . '" src="' . $url . '" frameborder="0" allowfullscreen allow="autoplay; fullscreen; picture-in-picture"></iframe>';
    }

    protected function setUp(): void
    {
        $environment = new Environment();
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new Extension());

        $this->converter = new MarkdownConverter($environment);
    }
}
