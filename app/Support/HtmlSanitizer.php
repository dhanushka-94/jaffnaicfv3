<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

/**
 * Small allow-list HTML sanitizer for admin-entered rich text and map embeds.
 *
 * Anything not explicitly allowed (script, style, event handlers, javascript: URLs,
 * unknown tags, iframes...) is removed, so a compromised or careless editor can never
 * inject script into public pages.
 */
class HtmlSanitizer
{
    /** @var array<string, list<string>> tag => allowed attributes */
    private const ALLOWED = [
        'p' => ['style'], 'br' => [], 'hr' => [], 'span' => [], 'div' => ['style'],
        'strong' => [], 'b' => [], 'em' => [], 'i' => [], 'u' => [], 's' => [], 'mark' => [],
        'sub' => [], 'sup' => [], 'small' => [], 'code' => [], 'pre' => [], 'blockquote' => [],
        'h1' => ['style'], 'h2' => ['style'], 'h3' => ['style'], 'h4' => ['style'], 'h5' => ['style'], 'h6' => ['style'],
        'ul' => [], 'ol' => ['start'], 'li' => [],
        'a' => ['href', 'title', 'target', 'rel'],
        'img' => ['src', 'alt', 'title', 'width', 'height'],
        'figure' => [], 'figcaption' => [],
        'table' => [], 'thead' => [], 'tbody' => [], 'tfoot' => [], 'tr' => [],
        'th' => ['colspan', 'rowspan'], 'td' => ['colspan', 'rowspan'],
    ];

    /** Tags removed together with their content. */
    private const DROP_WITH_CONTENT = ['script', 'style', 'iframe', 'object', 'embed', 'form', 'input', 'button', 'textarea', 'select', 'svg', 'math', 'link', 'meta', 'base', 'noscript', 'template'];

    public static function clean(?string $html): string
    {
        $html = trim((string) $html);

        if ($html === '') {
            return '';
        }

        $previous = libxml_use_internal_errors(true);

        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->loadHTML('<?xml encoding="UTF-8"><div id="__root">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $root = $doc->getElementById('__root');

        if (! $root) {
            return e($html);
        }

        self::cleanChildren($root);

        $out = '';

        foreach ($root->childNodes as $child) {
            $out .= $doc->saveHTML($child);
        }

        return $out;
    }

    /**
     * Keep only a Google Maps embed iframe (what venues store) and rebuild it from scratch.
     */
    public static function mapEmbed(?string $html): string
    {
        if (! $html || ! preg_match('/src\s*=\s*["\']([^"\']+)["\']/i', $html, $m)) {
            return '';
        }

        $src = html_entity_decode($m[1], ENT_QUOTES);
        $parts = parse_url($src);

        $allowedHosts = ['www.google.com', 'maps.google.com', 'www.google.lk'];

        if (
            ! $parts
            || ($parts['scheme'] ?? '') !== 'https'
            || ! in_array(strtolower($parts['host'] ?? ''), $allowedHosts, true)
            || ! str_starts_with($parts['path'] ?? '', '/maps')
        ) {
            return '';
        }

        return '<iframe src="' . e($src) . '" width="100%" height="100%" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Map"></iframe>';
    }

    private static function cleanChildren(DOMNode $parent): void
    {
        foreach (iterator_to_array($parent->childNodes) as $node) {
            if ($node instanceof DOMElement) {
                self::cleanElement($node);
            } elseif ($node->nodeType === XML_COMMENT_NODE || $node->nodeType === XML_PI_NODE || $node->nodeType === XML_CDATA_SECTION_NODE) {
                $parent->removeChild($node);
            }
        }
    }

    private static function cleanElement(DOMElement $el): void
    {
        $tag = strtolower($el->tagName);

        if (in_array($tag, self::DROP_WITH_CONTENT, true)) {
            $el->parentNode?->removeChild($el);

            return;
        }

        if (! array_key_exists($tag, self::ALLOWED)) {
            // Unknown tag: keep its (cleaned) text/children, drop the wrapper.
            self::cleanChildren($el);

            while ($el->firstChild) {
                $el->parentNode?->insertBefore($el->firstChild, $el);
            }

            $el->parentNode?->removeChild($el);

            return;
        }

        $allowedAttrs = self::ALLOWED[$tag];

        foreach (iterator_to_array($el->attributes) as $attr) {
            $name = strtolower($attr->name);
            $value = trim($attr->value);

            if (! in_array($name, $allowedAttrs, true) || ! self::attributeIsSafe($tag, $name, $value)) {
                $el->removeAttribute($attr->name);
            }
        }

        if ($tag === 'a') {
            if ($el->getAttribute('target') === '_blank') {
                $el->setAttribute('rel', 'noopener noreferrer');
            } else {
                $el->removeAttribute('target');
            }
        }

        if ($tag === 'img' && ! $el->hasAttribute('src')) {
            $el->parentNode?->removeChild($el);

            return;
        }

        self::cleanChildren($el);
    }

    private static function attributeIsSafe(string $tag, string $name, string $value): bool
    {
        return match ($name) {
            'href' => (bool) preg_match('~^(https?://|mailto:|tel:|/|#)~i', $value),
            'src' => (bool) preg_match('~^(https?://|/)~i', $value),
            'style' => (bool) preg_match('~^text-align:\s*(left|right|center|justify)\s*;?$~i', $value),
            'target' => $value === '_blank',
            'width', 'height', 'colspan', 'rowspan', 'start' => (bool) preg_match('~^\d{1,4}$~', $value),
            default => true,
        };
    }
}