<?php

namespace lucifer\Press\Fields;

class Extra extends FieldContract
{
    public static function process($type, $value, $data)
    {
        $extra = isset($data['extra']) ? json_decode($data['extra'], true) : [];

        return [
            'extra' => json_encode(array_merge($extra, [$type => $value]))
        ];
    }
}