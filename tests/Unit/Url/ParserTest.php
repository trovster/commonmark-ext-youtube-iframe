<?php

namespace Surface\CommonMark\Ext\YouTubeIframe\Tests\Unit\Url;

use ReflectionClass;
use Surface\CommonMark\Ext\YouTubeIframe\Tests\TestCase;
use Surface\CommonMark\Ext\YouTubeIframe\Url\Parser;

/** @group parser */
final class ParserTest extends TestCase
{
    protected Parser $parser;

    /** @test */
    public function getType(): void
    {
        $this->assertSame('example', $this->parser->getType());
    }

    /** @test */
    public function emptyUrl(): void
    {
        $url = $this->parser->parse('');

        $this->assertSame('example', $this->parser->getType());
        $this->assertNull($url);
    }

    /** @test */
    public function urlWithoutWidth(): void
    {
        $uuid = uniqid();
        $url = "https://example.com/example/{$uuid}";

        $result = $this->invokeMethod($this->parser, 'getWidth', [
            $url,
        ]);

        $this->assertSame(800, $result);
    }

    /**
     * @test
     * @dataProvider widthProvider
     * @param int|string $width
     * @param int|string|null $same
     */
    public function urlWithWidth($width, $same): void
    {
        $uuid = uniqid();
        $url = "https://example.com/example/{$uuid}?width={$width}";

        $result = $this->invokeMethod($this->parser, 'getWidth', [
            $url,
        ]);

        $this->assertSame($same, $result);
    }

    /** @test */
    public function urlWithoutHeight(): void
    {
        $uuid = uniqid();
        $url = "https://example.com/example/{$uuid}";

        $result = $this->invokeMethod($this->parser, 'getHeight', [
            $url,
        ]);

        $this->assertSame(600, $result);
    }

    /**
     * @test
     * @dataProvider heightProvider
     * @param int|string $height
     * @param int|string|null $same
     */
    public function urlWithHeight($height, $same): void
    {
        $uuid = uniqid();
        $url = "https://example.com/example/{$uuid}?height={$height}";

        $result = $this->invokeMethod($this->parser, 'getHeight', [
            $url,
        ]);

        $this->assertSame($same, $result);
    }

    /** @test */
    public function urlWithoutTimestamp(): void
    {
        $uuid = uniqid();
        $url = "https://example.com/example/{$uuid}";

        $result = $this->invokeMethod($this->parser, 'getTimestamp', [
            $url,
        ]);

        $this->assertNull($result);
    }

    /**
     * @test
     * @dataProvider timestampProvider
     * @param int|string $timestamp
     * @param int|string|null $same
     */
    public function urlWithTimestamp($timestamp, $same): void
    {
        $uuid = uniqid();
        $url = "https://example.com/example/{$uuid}?t={$timestamp}";

        $result = $this->invokeMethod($this->parser, 'getTimestamp', [
            $url,
        ]);

        $this->assertSame($same, $result);
    }

    protected function setUp(): void
    {
        $this->parser = $this->getMockForAbstractClass(Parser::class, [], 'Example');
    }

    /** @return mixed */
    protected function invokeMethod(object $object, string $methodName, array $parameters = [])
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
