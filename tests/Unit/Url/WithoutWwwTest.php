<?php

namespace Surface\CommonMark\Ext\YouTubeIframe\Tests\Unit\Url;

use Surface\CommonMark\Ext\YouTubeIframe\Tests\TestCase;
use Surface\CommonMark\Ext\YouTubeIframe\Url\Contracts\Url;
use Surface\CommonMark\Ext\YouTubeIframe\Url\Parsers\WithoutWww as Parser;

/** @group without-www */
final class WithoutWwwTest extends TestCase
{
    protected Parser $parser;
    protected string $uuid;
    protected string $url;

    /** @test */
    public function urlParsed(): void
    {
        $url = $this->parser->parse($this->url);

        $this->assertSame('full', $this->parser->getType());

        $this->assertInstanceOf(Url::class, $url);
        $this->assertSame('full', $url->getType());
        $this->assertSame($this->uuid, $url->getUuid());
        $this->assertSame(800, $url->getWidth());
        $this->assertSame(600, $url->getHeight());
        $this->assertNull($url->getTimestamp());
    }

    /** @test */
    public function urlParsedWithTimestamp(): void
    {
        $timestamp = 10;
        $url = $this->parser->parse("{$this->url}&t={$timestamp}");

        $this->assertSame('full', $this->parser->getType());

        $this->assertInstanceOf(Url::class, $url);
        $this->assertSame('full', $url->getType());
        $this->assertSame($this->uuid, $url->getUuid());
        $this->assertSame(800, $url->getWidth());
        $this->assertSame(600, $url->getHeight());
        $this->assertSame($timestamp, $url->getTimestamp());
    }

    /** @test */
    public function noUuid(): void
    {
        $url = $this->parser->parse('https://youtube.com/watch?v=');

        $this->assertSame('full', $this->parser->getType());
        $this->assertNull($url);
    }

    protected function setUp(): void
    {
        $this->parser = new Parser();
        $this->uuid = uniqid();
        $this->url = "https://youtube.com/watch?v={$this->uuid}";
    }
}
