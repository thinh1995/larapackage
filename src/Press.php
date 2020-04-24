<?php


namespace lucifer\Press;


use Illuminate\Support\Str;

class Press
{
    public static function configNotPublished()
    {
        return is_null(config('press'));
    }

    public static function driver()
    {
        $driver = Str::title(config('press.driver'));

        $class = 'lucifer\Press\Drivers\\' . $driver . 'Driver';

        return new $class;
    }
}