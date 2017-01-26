<?php

/**
 * Project: AegeanScraper
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */
class TestTest extends PHPUnit_Framework_TestCase
{
    public static function readFile($file)
    {
        return file_get_contents(__DIR__ . '/' . $file);
    }

    public function testReplyRedirect()
    {
        $scraper = new \projectivemotion\AegeanScraper\Scraper();
        $post2  =   $scraper->getRedirectPostInfo(self::readFile('posthandler_reply.html'));

        $this->assertEquals('https://e-ticket.aegeanair.com/A3Responsive/dyn/air/booking/#!/flight', $post2['action']);
        $this->assertCount(91, $post2['post']);
    }


}
