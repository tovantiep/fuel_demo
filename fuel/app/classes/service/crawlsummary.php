<?php

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class Service_Crawlsummary
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 10,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (FuelPHP Bot)'
            ],
        ]);
    }

    public function crawl($url): array
    {
        $response = $this->client->get($url);
        $html = (string) $response->getBody();

        $crawler = new Crawler($html);

        return $this->getSummary($crawler);

    }

    private function getSummary(Crawler $crawler): array
    {
        $articles = [];

        $contentHtml = $crawler->filter('div.singular-content')->count() > 0
            ? $crawler->filter('div.singular-content')->html()
            : '';

        // Xử lý thẻ <img> ngay khi crawl
        $contentHtml = preg_replace_callback('/<img[^>]*>/i', function ($matches) {
            $tag = $matches[0];
            $title = '';

            // Lấy title nếu có
            if (preg_match('/title="([^"]*)"/i', $tag, $m)) {
                $title = $m[1];
            }

            // Lấy src ưu tiên data-original → data-src → src
            if (preg_match('/data-original="([^"]+)"/i', $tag, $m)) {
                $src = $m[1];
            } elseif (preg_match('/data-src="([^"]+)"/i', $tag, $m)) {
                $src = $m[1];
            } elseif (preg_match('/src="([^"]+)"/i', $tag, $m)) {
                $src = $m[1];
            } else {
                $src = '';
            }

            // Trả về ảnh sạch (chỉ giữ src và title)
            return '<img'
                . ($title ? ' title="' . htmlspecialchars($title) . '"' : '')
                . ' src="' . htmlspecialchars($src) . '" style="max-width:100%;height:auto;">';
        }, $contentHtml);

        $articles[] = [
            'content_html' => $contentHtml
        ];

        return $articles;
    }

}
