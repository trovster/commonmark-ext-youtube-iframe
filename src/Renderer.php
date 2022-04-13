<?php

namespace Surface\CommonMark\Ext\YouTubeIframe;

use InvalidArgumentException;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;
use Surface\CommonMark\Ext\YouTubeIframe\Iframe;

final class Renderer implements InlineRendererInterface
{
    protected int $height;
    protected int $width;
    protected bool $allowFullScreen;

    public function __construct(int $width, int $height, bool $allowFullScreen = false)
    {
        $this->width = $width;
        $this->height = $height;
        $this->allowFullScreen = $allowFullScreen;
    }

    /** @return \League\CommonMark\HtmlElement|string|null */
    // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (! ($inline instanceof Iframe)) {
            throw new InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }

        $src = "https://www.youtube.com/embed/{$inline->getUrl()->getUuid()}";
        $timestamp = $inline->getUrl()->getTimestamp();
        $width = $inline->getUrl()->getWidth();
        $height = $inline->getUrl()->getHeight();

        if (null !== $timestamp) {
            $src .= "?start={$timestamp}";
        }

        return new HtmlElement('iframe', [
            'width' => $width ?: $this->width,
            'height' => $height ?: $this->height,
            'src' => $src,
            'frameborder' => 0,
            'allowfullscreen' => $this->allowFullScreen,
            'allow' => 'autoplay; fullscreen; picture-in-picture',
        ]);
    }
}
