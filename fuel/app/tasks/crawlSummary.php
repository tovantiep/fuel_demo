<?php

namespace Fuel\tasks;

class crawlSummary
{
    public static function run($id = null)
    {
        if ($id) {
            $postsEmpty = \Model_Post::query()
                ->where('id', $id)
                ->get();
        } else {
            $postsEmpty = \Model_Post::query()
                ->where('summary', '=', '')
                ->or_where('summary', 'is', null)
                ->where('content_link', 'is not', null)
                ->limit(10)
                ->get();
        }

        $crawler = new \Service_Crawlsummary();
        $countUpdated = 0;

        foreach ($postsEmpty as $post) {
            $crawled = $crawler->crawl($post->content_link);

            if (!empty($crawled[0]['content_html'])) {
                $post->summary = $crawled[0]['content_html'];
                $post->save();
                $countUpdated++;
            }
        }

        \Cli::write("{$countUpdated} bài viết đã được crawl và lưu.", 'green');
    }

}
