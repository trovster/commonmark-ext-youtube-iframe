<?php

namespace Surface\CommonMark\Ext\YouTubeIframe;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
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
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $width = $this->getWidth($environment);
        $height = $this->getHeight($environment);
        $fullScreen = $this->allowFullscreen($environment);

        $environment
            ->addEventListener(DocumentParsedEvent::class, new Processor([
                new Short($width, $height),
                new Full($width, $height),
                new WithoutWww($width, $height),
            ]))
            ->addRenderer(Iframe::class, new Renderer(
                $width,
                $height,
                $fullScreen
            ))
        ;
    }

    protected function getWidth(EnvironmentBuilderInterface $environment): int
    {
        if ($environment->getConfiguration()->exists('youtube_width')) {
            return (int) $environment->getConfiguration()->get('youtube_width');
        }

        return 800;
    }

    protected function getHeight(EnvironmentBuilderInterface $environment): int
    {
        if ($environment->getConfiguration()->exists('youtube_height')) {
            return (int) $environment->getConfiguration()->get('youtube_height');
        }

        return 600;
    }

    protected function allowFullscreen(EnvironmentBuilderInterface $environment): bool
    {
        if ($environment->getConfiguration()->exists('youtube_allowfullscreen')) {
            return (bool) $environment->getConfiguration()->get('youtube_allowfullscreen');
        }

        return true;
    }
}
