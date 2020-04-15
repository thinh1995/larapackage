<?php

namespace lucifer\Press\Tests;

use lucifer\Press\PressFileParser;
use Orchestra\Testbench\TestCase;

class PressFileParserTest extends TestCase
{
    /** @test */
    public function the_head_and_the_body_gets_split()
    {
        $pressFileParser = new PressFileParser(__DIR__.'/../blogs/MarkFile1.md');

        $data = $pressFileParser->getData();

        $this->assertStringContainsString('title: Title here', $data[1]);
        $this->assertStringContainsString('description: Description here', $data[1]);
        $this->assertStringContainsString('Blog post body here', $data[2]);
    }

    /** @test */
    public function each_head_field_gets_separate()
    {
        $pressFileParser = new PressFileParser(__DIR__.'/../blogs/MarkFile1.md');

        $data = $pressFileParser->getData();

        $this->assertStringContainsString('My title', $data['title']);
        $this->assertStringContainsString('Description here', $data['description']);
    }

    /** @test */
    public function the_body_gets_saved_and_trimmed()
    {
        $pressFileParser = new PressFileParser(__DIR__.'/../blogs/MarkFile1.md');

        $data = $pressFileParser->getData();

        $this->assertStringContainsString("# Heading\n\nBlog post body here", $data['body']);
    }
}