<?php

namespace Surface\CommonMark\Ext\YouTubeIframe;

use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\ExtensionInterface;
use Surface\CommonMark\Ext\YouTubeIframe\Iframe;
use Surface\CommonMark\Ext\YouTubeIframe\Processor;
use Surface\CommonMark\Ext\YouTubeIframe\Renderer;
use Surface\CommonMark\Ext\YouTubeIframe\Url\Parsers\Full;
use Surface\CommonMark\Ext\YouTubeIframe\Url\Parsers\Short;
use Surface\CommonMark\Ext\YouTubeIframe\Url\Parsers\WithoutWww;

final class Extension implements ExtensionInterface
{
    /** @return void */
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $width = (int) $environment->getConfig('youtube_width', 800);
        $height = (int) $environment->getConfig('youtube_height', 600);
        $fullScreen = (bool) $environment->getConfig('youtube_allowfullscreen', true);

        $environment
            ->addEventListener(DocumentParsedEvent::class, new Processor([
                new Short($width, $height),
                new Full($width, $height),
                new WithoutWww($width, $height),
            ]))
            ->addInlineRenderer(Iframe::class, new Renderer(
                $width,
                $height,
                $fullScreen
            ))
        ;
    }
}
