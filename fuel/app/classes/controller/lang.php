<?php
class Controller_Lang extends \Fuel\Core\Controller
{
    public function action_switch($lang = 'en')
    {
        $supported = ['en', 'vi'];

        if (!in_array($lang, $supported)) {
            $lang = 'en';
        }

        \Session::set('lang', $lang);

        \Config::set('language', $lang);

        return \Response::redirect_back('/');
    }


}