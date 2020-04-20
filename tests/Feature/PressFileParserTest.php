<?php

namespace lucifer\Press\Tests;

use Carbon\Carbon;
use lucifer\Press\PressFileParser;

class PressFileParserTest extends TestCase
{
    /** @test */
    public function the_head_and_the_body_gets_split()
    {
        $pressFileParser = new PressFileParser(__DIR__.'/../blogs/MarkFile1.md');

        $data = $pressFileParser->getRawData();

        $this->assertStringContainsString('title: My title', $data[1]);
        $this->assertStringContainsString('description: Description here', $data[1]);
        $this->assertStringContainsString('Blog post body here', $data[2]);
    }

    /** @test */
    public function a_string_can_also_be_used_instead()
    {
        $pressFileParser = new PressFileParser("---\ntitle: Title here\n---\nBlog post body here");

        $data = $pressFileParser->getRawData();

        $this->assertStringContainsString('title: Title here', $data[1]);
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

        $this->assertEquals("<h1>Heading</h1>\n<p>Blog post body here</p>", $data['body']);
    }

    /** @test */
    public function a_date_field_gets_parsed()
    {
        $pressFileParser = new PressFileParser("---\ndate: Apr 15, 2020\n---\n");

        $data = $pressFileParser->getData();

        $this->assertInstanceOf(Carbon::class, $data['date']);
        $this->assertEquals('04/15/2020', $data['date']->format('m/d/Y'));
    }

    /** @test */
    public function an_extra_field_gets_saved()
    {
        $pressFileParser = new PressFileParser("---\nauthor: Lucifer\n---\n");

        $data = $pressFileParser->getData();

        $this->assertEquals(json_encode(['author' => 'Lucifer']), $data['extra']);
    }

    /** @test */
    public function two_additional_fields_are_put_into_extra()
    {
        $pressFileParser = new PressFileParser("---\nauthor: Lucifer\nimage: some/image.jpg\n---\n");

        $data = $pressFileParser->getData();

        $this->assertEquals(json_encode(['author' => 'Lucifer', 'image' => 'some/image.jpg']), $data['extra']);
    }
}