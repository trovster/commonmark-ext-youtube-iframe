<?php

namespace Surface\CommonMark\Ext\YouTubeIframe;

use InvalidArgumentException;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use Surface\CommonMark\Ext\YouTubeIframe\Iframe;

final class Renderer implements NodeRendererInterface
{
    public function __construct(protected int $width, protected int $height, protected bool $allowFullScreen = false)
    {
    }

    /** @return \League\CommonMark\Util\HtmlElement|string|null */
    // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
    public function render(Node $inline, ChildNodeRendererInterface $htmlRenderer)
    {
        if (! ($inline instanceof Iframe)) {
            throw new InvalidArgumentException('Incompatible inline type: ' . $inline::class);
        }

        $src = "https://www.youtube.com/embed/{$inline->getUrl()->getUuid()}";
        $timestamp = $inline->getUrl()->getTimestamp();
        $width = $inline->getUrl()->getWidth();
        $height = $inline->getUrl()->getHeight();

        if (null !== $timestamp) {
            $src .= "?start={$timestamp}";
        }

        return new HtmlElement('iframe', [
            'width' => (string) ($width ?: $this->width),
            'height' => (string) ($height ?: $this->height),
            'src' => $src,
            'frameborder' => '0',
            'allowfullscreen' => $this->allowFullScreen,
            'allow' => 'autoplay; fullscreen; picture-in-picture',
        ]);
    }
}
