<?php

namespace lucifer\Press;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    public function extra($field)
    {
        return optional(json_decode($this->extra))->$field;
    }
}
