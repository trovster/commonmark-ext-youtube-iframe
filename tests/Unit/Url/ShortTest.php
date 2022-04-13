<?php

namespace Surface\CommonMark\Ext\YouTubeIframe\Tests\Unit\Url;

use Surface\CommonMark\Ext\YouTubeIframe\Tests\TestCase;
use Surface\CommonMark\Ext\YouTubeIframe\Url\Contracts\Url;
use Surface\CommonMark\Ext\YouTubeIframe\Url\Parsers\Short as Parser;

/** @group short */
final class ShortTest extends TestCase
{
    protected Parser $parser;
    protected string $uuid;
    protected string $url;

    /** @test */
    public function urlParsed(): void
    {
        $url = $this->parser->parse($this->url);

        $this->assertSame('short', $this->parser->getType());

        $this->assertInstanceOf(Url::class, $url);
        $this->assertSame('short', $url->getType());
        $this->assertSame($this->uuid, $url->getUuid());
        $this->assertSame(800, $url->getWidth());
        $this->assertSame(600, $url->getHeight());
        $this->assertNull($url->getTimestamp());
    }

    /** @test */
    public function urlParsedWithTimestamp(): void
    {
        $timestamp = 10;
        $url = $this->parser->parse("{$this->url}?t={$timestamp}");

        $this->assertSame('short', $this->parser->getType());

        $this->assertInstanceOf(Url::class, $url);
        $this->assertSame('short', $url->getType());
        $this->assertSame($this->uuid, $url->getUuid());
        $this->assertSame(800, $url->getWidth());
        $this->assertSame(600, $url->getHeight());
        $this->assertSame($timestamp, $url->getTimestamp());
    }

    /** @test */
    public function noUuid(): void
    {
        $url = $this->parser->parse('https://youtu.be/');

        $this->assertSame('short', $this->parser->getType());
        $this->assertNull($url);
    }

    protected function setUp(): void
    {
        $this->parser = new Parser();
        $this->uuid = uniqid();
        $this->url = "https://youtu.be/{$this->uuid}";
    }
}
