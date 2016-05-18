<?php

class FilterTest extends PHPUnit_Framework_TestCase
{

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    public static function setUpBeforeClass()
    {

    }


    /**
     * @dataProvider getData
     */
    public function testFilters($filter_rules, $data, $returns)
    {
        $filter = new \Buuum\Filter($filter_rules);
        $data = $filter->filter($data);

        foreach ($data as $name => $value) {
            $this->assertEquals($value, $returns[$name]);
        }

    }

    public function getData()
    {
        return [
            [
                [
                    'name'    => 'trim|sanitize_string',
                    'email'   => 'trim|sanitize_email',
                    'text'    => 'trim|rmpunctuation',
                    'url'     => 'urlencode',
                    'html'    => 'htmlencode',
                    'number'  => 'sanitize_numbers',
                    'tags'    => 'tags',
                    'ctags'   => 'custom_tags:<p>:<h1>',
                    'ctags2'  => 'custom_tags:<iframe>',
                    'ctags3'  => 'custom_tags:<strong>:<p>',
                    'ctags4'  => 'custom_tags:<p>:<h1>:<img>',
                    'attr'    => 'attributes',
                    'wnumber' => 'whole_number',
                    'wnumber2' => 'whole_number',
                    'wnumber3' => 'whole_number',
                    'wnumber4' => 'whole_number',
                ],
                [
                    'name'    => ' hola que tal',
                    'email'   => ' (email@email.com ',
                    'text'    => ' lorem ipsum. Lorem: Ipsum :: !LOREM!!. New Lorem, ipsum.',
                    'url'     => 'https://www.google.com',
                    'html'    => '<h1>Hola</h1><p>Demo p with <strong class="democlass">strong</strong></p>',
                    'number'  => 're45fffccc09',
                    'tags'    => '<h1>Hola</h1><p>Demo p with <img src="imgpath" /> <iframe src="http://example.com"></iframe> <strong class="democlass">strong</strong></p>',
                    'ctags'   => '<h1>Hola</h1><p>Demo p with <img src="imgpath" /> <iframe src="http://example.com"></iframe> <strong class="democlass">strong</strong></p>',
                    'ctags2'  => '<h1>Hola</h1><p>Demo p with <img src="imgpath" /> <iframe src="http://example.com"></iframe> <strong class="democlass">strong</strong></p>',
                    'ctags3'  => '<h1>Hola</h1><p>Demo p with <img src="imgpath" /> <iframe src="http://example.com"></iframe> <strong class="democlass">strong</strong></p>',
                    'ctags4'  => '<h1>Hola</h1><p>Demo p with <img src="imgpath" /> <iframe src="http://example.com"></iframe> <strong class="democlass">strong</strong></p>',
                    'attr'    => '<h1>Hola</h1><p>Demo p with <img src="imgpath" /> <iframe src="http://example.com"></iframe> <strong class="democlass">strong</strong></p>',
                    'wnumber' => -34,
                    'wnumber2' => -34.54,
                    'wnumber3' => "r43f.er3",
                    'wnumber4' => "5655.44",
                ],
                [
                    'name'    => 'hola que tal',
                    'email'   => 'email@email.com',
                    'text'    => 'lorem ipsum. Lorem Ipsum  LOREM. New Lorem ipsum.',
                    'url'     => urlencode('https://www.google.com'),
                    'html'    => filter_var('<h1>Hola</h1><p>Demo p with <strong class="democlass">strong</strong></p>',
                        FILTER_SANITIZE_SPECIAL_CHARS),
                    'number'  => 4509,
                    'tags'    => 'HolaDemo p with   strong',
                    'ctags'   => '<h1>Hola</h1><p>Demo p with   strong</p>',
                    'ctags2'  => 'HolaDemo p with  <iframe src="http://example.com"></iframe> strong',
                    'ctags3'  => 'Hola<p>Demo p with   <strong class="democlass">strong</strong></p>',
                    'ctags4'  => '<h1>Hola</h1><p>Demo p with <img src="imgpath" />  strong</p>',
                    'attr'    => '<h1>Hola</h1><p>Demo p with <img/> <iframe></iframe> <strong>strong</strong></p>',
                    'wnumber' => -34,
                    'wnumber2' => -34,
                    'wnumber3' => 0,
                    'wnumber4' => 5655,
                ]
            ]
        ];
    }
}