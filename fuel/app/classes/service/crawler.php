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

    public function crawl()
    {
        $url = 'https://dantri.com.vn/tin-moi-nhat.htm';
        $response = $this->client->get($url);
        $html = (string) $response->getBody();

        $crawler = new Crawler($html);

        $articles = [];

        $crawler->filter('div.article.list.article-newest article.article-item')->each(function (Crawler $node) use (&$articles) {
            $dataId       = $node->attr('data-id');
            $contentLink  = $node->attr('data-content-target');

            $titleNode    = $node->filter('h2.article-title a, h3.article-title a');
            $title        = $titleNode->count() ? $titleNode->text() : '';

            $descNode     = $node->filter('.article-excerpt a');
            $description  = $descNode->count() ? $descNode->text() : '';

            $link         = $titleNode->count() ? $titleNode->attr('href') : '';

            $imgNode      = $node->filter('.article-thumb img');
            $image        = $imgNode->count() ? $imgNode->attr('src') : '';

            $articles[] = [
                'post_id'       => $dataId,
                'title'         => html_entity_decode(trim($title)),
                'description'   => html_entity_decode(trim($description)),
                'image_link'    => str_starts_with($image, 'http') ? $image : 'https://dantri.com.vn' . $image,
                'content_link'  => str_starts_with($link, 'http') ? $link : 'https://dantri.com.vn' . $link,
            ];
        });
        return $articles;
    }
}
