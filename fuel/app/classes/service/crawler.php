<?php

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class Service_Crawler
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

    public function crawl($categoryId = 1): array
    {
        $url = match ($categoryId) {
            2 => 'https://dantri.com.vn/kinh-doanh.htm',
            3 => 'https://dantri.com.vn/xa-hoi.htm',
            4 => 'https://dantri.com.vn/the-thao.htm',
            default => 'https://dantri.com.vn/tin-moi-nhat.htm',
        };

        $response = $this->client->get($url);
        $html = (string) $response->getBody();

        $crawler = new Crawler($html);

        if ($categoryId === 1) {
            return $this->parseArticlesCategory1($crawler);
        }

        return $this->parseArticlesCategory234($crawler, $categoryId);

    }


    protected function parseArticlesCategory1(Crawler $crawler): array
    {
        $articles = [];
        $crawler->filter('div.article.list.article-newest article.article-item')->each(function (Crawler $node) use (&$articles) {
            $articles[] = [
                'category_id'   => 1,
                'post_id'       => $node->attr('data-id'),
                'title'         => $this->getTextFromNode($node, 'h2.article-title a, h3.article-title a'),
                'description'   => $this->getTextFromNode($node, '.article-excerpt a'),
                'image_link'    => $this->getImageSrc($node, '.article-thumb img'),
                'content_link'  => $this->getHrefFromNode($node, 'h2.article-title a, h3.article-title a'),
            ];
        });
        return $articles;
    }

    protected function parseArticlesCategory234(Crawler $crawler, int $categoryId): array
    {
        $articles = [];
        $crawler->filter('div.article.list article.article-item')->each(function (Crawler $node) use (&$articles, $categoryId) {

            $postId = $description = $imageLink =  '';
            $commentSpan = $node->filter('span.article-total-comment');
            if ($commentSpan->count()) {
                $postId = $commentSpan->attr('data-id') ?? '';
            }

            $descNode = $node->filter('div.article-excerpt a');
            if ($descNode->count()) {
                $description = trim(html_entity_decode($descNode->text()));
            }

            $imgNode = $node->filter('.article-thumb img');
            if ($imgNode->count()) {
                $src = $imgNode->attr('data-src') ?: $imgNode->attr('src');
                if ($src) {
                    $imageLink = str_starts_with($src, 'http') ? $src : 'https://dantri.com.vn' . $src;
                }
            }


            $articles[] = [
                'category_id'   => $categoryId,
                'post_id'       => $postId,
                'title'         => $this->getTextFromNode($node, 'h3.article-title a'),
                'description'   => $description,
                'image_link'    => $imageLink,
                'content_link'  => $this->getHrefFromNode($node, 'h3.article-title a'),
            ];
        });
        return $articles;
    }

    protected function getTextFromNode(Crawler $node, string $selector): string
    {
        $subNode = $node->filter($selector);
        return $subNode->count() ? trim(html_entity_decode($subNode->text())) : '';
    }

    protected function getHrefFromNode(Crawler $node, string $selector): string
    {
        $subNode = $node->filter($selector);
        if ($subNode->count()) {
            $href = $subNode->attr('href');
            return str_starts_with($href, 'http') ? $href : 'https://dantri.com.vn' . $href;
        }
        return '';
    }

    protected function getImageSrc(Crawler $node, string $selector): string
    {
        $imgNode = $node->filter($selector);
        if ($imgNode->count()) {
            $src = $imgNode->attr('src');
            return str_starts_with($src, 'http') ? $src : 'https://dantri.com.vn' . $src;
        }
        return '';
    }
}
