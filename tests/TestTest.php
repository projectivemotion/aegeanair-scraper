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

    public function testExtractApiParams()
    {
        $scraper = new \projectivemotion\AegeanScraper\Scraper();
        $params  =   $scraper->getApiParams(self::readFile('booking_reply.html'));
        $post2 = $params['js'];

        $this->assertNotEmpty($post2);
        $this->assertArrayHasKey('jsessionid', $post2);
        $this->assertArrayHasKey('entryRequestParams', $post2);
        $this->assertArrayHasKey('firstBeCallTargetName', $post2);

        $this->assertInternalType('object', $post2['entryRequestParams']);
        $this->assertInternalType('string', $post2['firstBeCallTargetName']);
        $this->assertEquals('x4_cr0ru5r6aqkC8woLocwxF7lTfdL_F7DcsCPJ8D-9LYqTQoe2s!1149321654!-410121848!1485466192622', $post2['jsessionid']);

        $this->assertEquals('ATHA308AA', $post2['entryRequestParams']->SO_SITE_QUEUE_OFFICE_ID);
        $this->assertEquals('https://en.aegeanair.com/PromoCodeHandler.axd', $post2['entryRequestParams']->WDS_PROMOCODE_HANDLER_URL);
    }

}
