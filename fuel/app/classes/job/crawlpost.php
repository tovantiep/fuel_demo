<?php

class Job_CrawlPost
{

    public function fire($job, $data)
    {
        echo 123123;
        // Test dừng ở đây để xem job có chạy không
        // exit;
        die();
        $crawler = new Service_Crawler();
        $posts = $crawler->crawl();

        foreach ($posts as $post) {
            $exists = Model_Post::find('first', [
                'where' => ['data_id' => $post['data_id']]
            ]);

            if (!$exists) {
                Model_Post::forge($post)->save();
            }
        }

        echo count($posts) . " bài viết được xử lý.\n";

        // Xóa job khỏi queue
        $job->delete();
    }
}
