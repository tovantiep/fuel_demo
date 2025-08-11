<?php
class Controller_Crawl extends Controller
{
    public function action_crawl_dantri()
    {

        \JobQueue\Queue::push('CrawlPost',[]);


        return Response::forge('Đã gửi job CrawlDantri vào queue.');
    }

}