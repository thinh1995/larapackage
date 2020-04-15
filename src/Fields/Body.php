<?php

namespace lucifer\Press\Fields;

use Carbon\Carbon;
use lucifer\Press\MarkdownParser;

class Body 
{
    public static function process($type, $value)
    {
        return [
            $type => MarkdownParser::parse($value),
            'parsed_at' => Carbon::now(),
        ];
    }
}
