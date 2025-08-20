<?php

class Presenter_Welcome_Index extends Presenter
{
    public function view()
    {
        $formattedPosts = [];

        foreach ($this->posts as $post) {
            $date = new \DateTime('@' . $post->created_at);
            $date->modify('+7 hours');

            $formattedPosts[] = [
                'id'          => $post->id,
                'title'       => $post->title,
                'description' => $post->description,
                'image_link'  => $post->image_link,
                'content_link'=> $post->content_link,
                'summary'     => $post->summary,
                'created_at'  => $date->format('H:i d/m/Y'),
            ];
        }

        $this->posts = $formattedPosts;

    }
}
