<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

const TRANSLATABLE_ATTRIBUTES = 'placeholder|aria-label|title|alt|label|subtitle|hint|heading';

const UNTRANSLATED_MARKUP = [
    '/\{\{--.*?--\}\}/s',
    '/\{!!.*?!!\}/s',
    '/\{\{.*?\}\}/s',
    '/@php\b.*?@endphp/s',
    '/@verbatim\b.*?@endverbatim/s',
    '/<script\b[^>]*>.*?<\/script>/s',
    '/<style\b[^>]*>.*?<\/style>/s',
    '/<template\b[^>]*>.*?<\/template>/s',
    '/<code\b[^>]*>.*?<\/code>/s',
    '/<x-ui\.code\b[^>]*>.*?<\/x-ui\.code>/s',
    '/<x-admin\.command\b[^>]*>.*?<\/x-admin\.command>/s',
    '/<pre\b[^>]*>.*?<\/pre>/s',
    '/<kbd\b[^>]*>.*?<\/kbd>/s',
    '/@\w+\s*\((?:[^()]|\((?:[^()]|\([^()]*\))*\))*\)/s',
];

/** Names, units and entities that mean the same in every language. */
const UNTRANSLATED_WORDS = [
    '&gt;', '&lt;', '&amp;',
];

/**
 * @return array<int, string>
 */
function bladeFiles(): array
{
    $root = dirname(__DIR__, 2).'/resources/views';
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root));
    $paths = [];

    foreach ($files as $file) {
        if ($file instanceof SplFileInfo && Str::endsWith($file->getFilename(), '.blade.php')) {
            $paths[] = $file->getPathname();
        }
    }

    sort($paths);

    return $paths;
}

/**
 * Blank out everything a translator never sees, keeping the offsets intact.
 */
function renderableMarkup(string $contents): string
{
    foreach (UNTRANSLATED_MARKUP as $pattern) {
        $contents = (string) preg_replace_callback(
            $pattern,
            fn (array $match): string => str_repeat(' ', strlen(Arr::get($match, 0))),
            $contents
        );
    }

    return $contents;
}

/**
 * A label the transformer could wrap on its own: literal text, nothing of the
 * masked markup left inside it.
 *
 * @return array<int, string>
 */
function untranslatedLabels(string $contents, string $markup): array
{
    preg_match_all('/>([^<>{}@]*\p{L}{2,}[^<>{}@]*)</u', $markup, $texts, PREG_OFFSET_CAPTURE);
    preg_match_all(
        '/(?<![\w:.\-])(?:'.TRANSLATABLE_ATTRIBUTES.')="([^"{}]*\p{L}{2,}[^"{}]*)"/u',
        $markup, $attributes, PREG_OFFSET_CAPTURE
    );

    return collect([...Arr::get($texts, 1, []), ...Arr::get($attributes, 1, [])])
        ->filter(fn (array $match): bool => substr($contents, (int) Arr::get($match, 1), strlen((string) Arr::get($match, 0))) === Arr::get($match, 0))
        ->map(fn (array $match): string => (string) Str::of((string) Arr::get($match, 0))->replace('&nbsp;', ' ')->squish())
        ->filter(fn (string $label): bool => $label !== ''
            && preg_match('/\p{L}{2,}/u', $label) === 1
            && ! in_array($label, UNTRANSLATED_WORDS, true))
        ->values()
        ->all();
}

it('writes every visible label through the translation helper', function () {
    $root = dirname(__DIR__, 2);
    $offences = [];

    foreach (bladeFiles() as $path) {
        $relative = Str::after($path, $root.DIRECTORY_SEPARATOR);
        $contents = (string) file_get_contents($path);

        foreach (untranslatedLabels($contents, renderableMarkup($contents)) as $label) {
            $offences[] = $relative.': '.Str::limit($label, 60);
        }
    }

    expect($offences)->toBe([]);
})->group('core', 'architecture');
