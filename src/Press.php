<?php


namespace lucifer\Press;


use Illuminate\Support\Str;

class Press
{
    protected $fields = [];

    public function configNotPublished()
    {
        return is_null(config('press'));
    }

    public function driver()
    {
        $driver = Str::title(config('press.driver'));

        $class = 'lucifer\Press\Drivers\\' . $driver . 'Driver';

        return new $class;
    }

    public function path()
    {
        return config('press.path', 'blogs');
    }

    public function fields(array $fields)
    {
        $this->fields = array_merge($this->fields, $fields);
    }

    public function availableFields()
    {
        return $this->fields;
    }
}