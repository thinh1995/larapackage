<?php


namespace lucifer\Press\Console;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use lucifer\Press\Post;
use lucifer\Press\Press;
use lucifer\Press\PressFileParser;

class ProcessCommand extends Command
{
    protected $signature = 'press:process';

    protected $description = 'Update blog post.';

    public function handle()
    {
        if (Press::configNotPublished()) {
            return $this->warn('Please publish the config file by running '.'\'php artisan vendor:publish --tag=press-config\'');
        }

        $posts = Press::driver()->fetchPosts();

        foreach ($posts as $post) {
            Post::create([
                'identifier' => Str::random(),
                'slug' => Str::slug($post['title']),
                'title' => $post['title'],
                'body' => $post['body'],
                'extra' => $post['extra'] ?? '',
            ]);
        }
    }
}
