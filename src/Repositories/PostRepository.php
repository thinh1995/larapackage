<?php


namespace lucifer\Press\Repositories;


use Illuminate\Support\Str;
use lucifer\Press\Post;

class PostRepository
{
    public function save($post)
    {
        Post::updateOrCreate([
            'identifier' => $post['identifier'],
        ],[
            'slug' => Str::slug($post['title']),
            'title' => $post['title'],
            'body' => $post['body'],
            'extra' => $this->extra($post),
        ]);
    }

    private function extra($post)
    {
        $extra = (array) json_decode($post['extra'] ?? '[]');
        $attributes = array_except($post, ['title', 'body', 'identifier', 'extra']);

        return json_encode(array_merge($extra, $attributes));
    }
}
