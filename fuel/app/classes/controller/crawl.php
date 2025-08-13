<?php
class Controller_Crawl extends Controller
{
    public function action_crawl_dantri()
    {
        if (!\Util\AuthUtil::isAdmin()) {
            return Response::forge('Forbidden', 403);
        }

        $categoryId = (int) Input::get('category_id', 1);


        $allowedCategories = [1, 2, 3, 4, 5, 6, 7, 8];
        if (!in_array($categoryId, $allowedCategories, true)) {
            return json_encode([
                'success' => false,
                'message' => 'Category không phải của báo Dân Trí'
            ]);
        }

        $crawler = new Service_Crawler();
        $posts = $crawler->crawl($categoryId);
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

        return json_encode([
            'success' => true,
            'message' => "{$newCount} bài viết mới được lưu."
        ]);

    }

}