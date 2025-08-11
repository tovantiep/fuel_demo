<?php
class Controller_Crawl extends Controller
{
    public function action_crawl_dantri()
    {
        $crawler = new Service_Crawler();
        $posts = $crawler->crawl();

        foreach ($posts as $post) {
            $exists = Model_Post::find('first', [
                'where' => ['post_id' => $post['post_id']]
            ]);

            if (!$exists) {
                Model_Post::forge($post)->save();
            }
        }

        echo count($posts) . " bài viết được xử lý.\n";

    }

}