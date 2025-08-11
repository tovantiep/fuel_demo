<?php
class Controller_Crawl extends Controller
{
    public function action_crawl_dantri()
    {
        $crawler = new Service_Crawler();
        $posts = $crawler->crawl();
        $newCount = 0;

        foreach ($posts as $post) {
            $exists = Model_Post::find('first', [
                'where' => ['post_id' => $post['post_id']]
            ]);

            if (!$exists) {
                if (Model_Post::forge($post)->save()) {
                    $newCount++;
                }
            }
        }

        echo $newCount . " bài viết mới được lưu.\n";

    }

}