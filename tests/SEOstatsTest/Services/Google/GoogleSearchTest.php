<?php

namespace SEOstatsTest\Services\Google;

use SEOstats\Services\Sitrix;

class GoogleSearchTest extends AbstractGoogleTestCase
{
    protected $standardVersionFile = "google-search-%s.html";
    protected $standardVersionSubFile = "google-search-%s-%s-%s.html";
    public $called = 0;

    /**
     * @group google
     * @group google-search
     * @group live
     */
    public function testGetPageRank()
    {
        $result = $this->SUT->getPageRank();

        $this->assertInternalType('string', $result);
        $this->assertGreaterThanOrEqual(0, $result);
    }

    /**
     * @dataProvider providerTestGoogleCurl
     * @group google
     * @group google-search
     * @group live
     */
    public function testGoogleCurl($args, $status)
    {
        $result = $this->helperMakeAccessable($this->SUT, 'gCurl', $args);

        if ($status) {
            $this->assertInternalType('string', $result);
            $this->assertTrue(strlen($result) >= 1);

        } else {
            $this->assertFalse($result);
        }
    }

    /**
     * @dataProvider providerTestGetSerps
     * @todo value controll
     * @group google
     * @group google-search
     */
    public function testGetSerps($args, $version, $assertResultCount)
    {
        $this->mockSUT('getSerps');
        $this->mockGCurl ($version);

        $result = $this->helperMakeAccessable($this->mockedSUT, 'getSerps', $args);

        $this->assertEquals($assertResultCount, count($result));
    }


    public function providerTestGoogleCurl()
    {
        $query = rawurlencode('github.com');

        $result   = array();

        // @todo implement cookie support in tests
        $result[] = array(array(# $path, $ref, $useCookie
                                sprintf('search?q=%s&filter=0', $query),
                                'ncr',
                                false
                          ),
                          true);
        $result[] = array(array(# $path, $ref, $useCookie
                                sprintf('search?q=%s&filter=0', $query),
                                '',
                                false
                          ),
                          true);

        return $result;
    }


    public function providerTestGetSerps()
    {
        // query, $maxResults=100, $domain=false
        $query = 'github.com';

        $args = array( $query, 10, false );
        $result[] = array($args, '2014', 15); // github.com result gives more than 10 results on first page
        $result[] = array($args, 'failed', 0);

        // @TODO fix domain filter regexp
        // $args = array( $query, 10, 'github.com' );
        // $result[] = array($args, '2014', 0);
        // $result[] = array($args, 'failed', 0);



        // @TODO add support for 4, 15 , 25 maxResult to
        // $args = array( $query, 15, false );
        // $result[] = array($args, '2014', 15);
        // $result[] = array($args, 'failed', 0);

        // @TODO fix domain filter regexp
        // $args = array( $query, 15, 'github.com' );
        // $result[] = array($args, '2014', 15);
        // $result[] = array($args, 'failed', 0);




        // @TODO fix domain filter regexp
        // $args = array( $query, 10, 'github.com' );
        // $result[] = array($args, '2014', 0);
        // $result[] = array($args, 'failed', 0);

        $args = array( $query, 20, false );
        $result[] = array($args, '2014', 25);
        $result[] = array($args, 'failed', 0);

        // @TODO fix domain filter regexp
        // $args = array( $query, 20, 'github.com' );
        // $result[] = array($args, '2014', 20);
        // $result[] = array($args, 'failed', 0);


        return $result;
    }

    public function setUp ()
    {
        parent::setUp();
        $this->called = 1;
    }

    protected function mockGCurl ($version)
    {
        $standardFile = $this->getAssertDirectory() . $this->standardVersionFile;
        $that = $this;

        $this->mockedSUT->staticExpects($this->any())
                        ->method('gCurl')
                        ->will($this->returnCallback(function() use ($standardFile, $version, $that) {
                            $file = sprintf($standardFile, $version . '-page-' . $that->called);

                            if (!file_exists($file)) {
                                $file = sprintf($standardFile, $version);
                            }
                            $that->called++;

                            return file_get_contents($file);
                        }));
    }
}