<?php

namespace lucifer\Press\Fields;

use Carbon\Carbon;
use lucifer\Press\MarkdownParser;

class Body extends FieldContract
{
    public static function process($type, $value, $data)
    {
        return [
            $type => MarkdownParser::parse($value),
            'parsed_at' => Carbon::now(),
        ];
    }
}
