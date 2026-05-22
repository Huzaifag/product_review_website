<?php
// app/Services/TranslationService.php

namespace App\Services;

class TranslationService
{
    protected array $targets = ['en', 'nl', 'de']; // ← add/remove languages here

    // -------------------------------------------------------
    // 1. Detect language → returns code like 'en', 'nl', 'de'
    // -------------------------------------------------------
    public function detectLanguage(string $text): ?string
    {
        $url = 'https://translate.googleapis.com/translate_a/single'
            . '?client=gtx&sl=auto&tl=en'
            . '&dt=t&q=' . urlencode($text);

        $response = $this->curl($url);

        if (!$response)
            return null;

        $data = json_decode($response, true);
        return $data[2] ?? null; // 'en', 'nl', 'de', etc.
    }

    // -------------------------------------------------------
    // 2. Translate into all target languages
    //    Returns: ['en' => '...', 'nl' => '...', 'de' => '...']
    // -------------------------------------------------------
    public function translateToLanguages(string $text, string $sourceCode): array
    {
        $results = [];

        foreach ($this->targets as $lang) {

            // Source lang = target lang, no API call needed
            if ($lang === $sourceCode) {
                $results[$lang] = $text;
                continue;
            }

            $url = 'https://translate.googleapis.com/translate_a/single'
                . '?client=gtx'
                . '&sl=' . urlencode($sourceCode)
                . '&tl=' . urlencode($lang)
                . '&dt=t'
                . '&q=' . urlencode($text);

            $response = $this->curl($url);

            if (!$response) {
                $results[$lang] = null;
                continue;
            }

            $data = json_decode($response, true);

            $translated = '';
            foreach (($data[0] ?? []) as $part) {
                if (isset($part[0]))
                    $translated .= $part[0];
            }

            $results[$lang] = trim($translated) ?: null;

            usleep(300000); // 0.3s between requests
        }

        return $results;
    }

    // -------------------------------------------------------
    // Convenience: detect + translate in one call
    // -------------------------------------------------------
    public function detectAndTranslate(string $text): array
    {
        $sourceCode = $this->detectLanguage($text);

        if (!$sourceCode) {
            return [];
        }

        return $this->translateToLanguages($text, $sourceCode);
    }

    // -------------------------------------------------------
    // Translate multiple texts at once — one detect call,
    // all translation requests fired in parallel.
    // Returns: ['name' => ['en' => '...', 'nl' => '...'], ...]
    // -------------------------------------------------------
    public function detectAndTranslateMany(array $texts): array
    {
        $texts = array_filter($texts, fn($t) => !empty($t));
        if (empty($texts)) return [];

        $sourceCode = $this->detectLanguage(current($texts));
        if (!$sourceCode) return [];

        // Build every (textKey, lang) pair that needs an API call
        $results = [];
        $pending = [];

        foreach ($texts as $textKey => $text) {
            $results[$textKey] = [];
            foreach ($this->targets as $lang) {
                if ($lang === $sourceCode) {
                    $results[$textKey][$lang] = $text;
                } else {
                    $pending[] = ['textKey' => $textKey, 'text' => $text, 'lang' => $lang];
                }
            }
        }

        if (empty($pending)) return $results;

        // Fire all requests in parallel
        $urls = [];
        foreach ($pending as $i => $item) {
            $urls[$i] = 'https://translate.googleapis.com/translate_a/single'
                . '?client=gtx'
                . '&sl=' . urlencode($sourceCode)
                . '&tl=' . urlencode($item['lang'])
                . '&dt=t'
                . '&q=' . urlencode($item['text']);
        }

        $responses = $this->curlMulti($urls);

        foreach ($pending as $i => $item) {
            $response = $responses[$i] ?? null;
            if (!$response) {
                $results[$item['textKey']][$item['lang']] = null;
                continue;
            }
            $data = json_decode($response, true);
            $translated = '';
            foreach (($data[0] ?? []) as $part) {
                if (isset($part[0])) $translated .= $part[0];
            }
            $results[$item['textKey']][$item['lang']] = trim($translated) ?: null;
        }

        return $results;
    }

    // -------------------------------------------------------
    // Shared cURL helper
    // -------------------------------------------------------
    private function curl(string $url): ?string
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => 'Mozilla/5.0',
            CURLOPT_TIMEOUT => 15,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ($httpCode === 200 && $response) ? $response : null;
    }

    // -------------------------------------------------------
    // Parallel cURL — fires all URLs simultaneously
    // -------------------------------------------------------
    private function curlMulti(array $urls): array
    {
        $mh = curl_multi_init();
        $handles = [];

        foreach ($urls as $i => $url) {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_USERAGENT     => 'Mozilla/5.0',
                CURLOPT_TIMEOUT       => 15,
                CURLOPT_SSL_VERIFYPEER => false,
            ]);
            curl_multi_add_handle($mh, $ch);
            $handles[$i] = $ch;
        }

        $running = null;
        do {
            curl_multi_exec($mh, $running);
            curl_multi_select($mh);
        } while ($running > 0);

        $responses = [];
        foreach ($handles as $i => $ch) {
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $body     = curl_multi_getcontent($ch);
            $responses[$i] = ($httpCode === 200 && $body) ? $body : null;
            curl_multi_remove_handle($mh, $ch);
            curl_close($ch);
        }

        curl_multi_close($mh);
        return $responses;
    }
}