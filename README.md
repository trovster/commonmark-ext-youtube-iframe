# YouTube iframe extension

An extension for [league/commonmark](https://github.com/thephpleague/commonmark)
version 1 built using PHP 7.4. This replaces YouTube links with the embed iframe.

The extension supports for the primary YouTube URL, with and without prefixed with
the `www`. It also supports the short shareable URL using the `youtu.be` domain.

Initially based on the [YouTube extension](https://github.com/zoonru/commonmark-ext-youtube-iframe).

## Installation

The project should be installed via Composer:

```bash
composer require surface/commonmark-ext-youtube-iframe
```

## Usage

Configure your CommonMark `Environment` and add the extension.

```php
use League\CommonMark\CommonMarkConverter as Converter;
// use League\CommonMark\GithubFlavoredMarkdownConverter as Converter;
use League\CommonMark\Environment;
use Surface\CommonMark\Ext\YouTubeIframe\Extension as YouTubeExtension;

$environment = Environment::createCommonMarkEnvironment();
$environment->addExtension(new YouTubeExtension());

$config = [
    'youtube_width' => '800',
    'youtube_height' => '600',
];

$converter = new Converter($config, $environment);

echo $converter->convertToHtml('[](https://youtu.be/xxx)');
echo $converter->convertToHtml('[](https://www.youtube.com/watch?v=xxx)');
echo $converter->convertToHtml('[](https://youtu.be/xxx?height=480)');
echo $converter->convertToHtml('[](https://www.youtube.com/watch?v=xxx&width=640)');
```

### Dimensions

You can control the dimensions of the videos by using the `youtube_width` and
`youtube_height` configuration options.

You can also configure the dimensions using query parameters on the embed URL.
You can provide the `height` or `width` or *both*.

```html
?width=640
?height=480
?width=640&height=480
```

## Testing

There are Unit and Integration tests for the project. These can be run using
the following commands:

```bash
composer test
composer run test
composer run test-unit
composer run test-integration
```

There are also scripts to run code sniffer, mess detector and static analysis:

```bash
composer run sniff
composer run mess
composer run stan
```

## Changelog

Please refer to the [CHANGELOG](CHANGELOG.md) for more information on what has
changed recently.

## License

This library is licensed under the MIT license. See the
[License File](LICENSE.md) for more information.
