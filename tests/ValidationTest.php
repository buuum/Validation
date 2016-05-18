<?php

class ValidationTest extends PHPUnit_Framework_TestCase
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



    public function testValidationRequired()
    {
        $messages = [
            "required" => "The :attribute is required",
        ];

        $rules = [
            'input1' => 'required'
        ];

        $datas = [
            ['input1' => ''],
            ['input1' => ' '],
            ['input1' => 0],
        ];

        $validation = new \Buuum\Validation($rules, $messages);


        foreach ($datas as $data) {
            $validation->validate($data);
            var_dump($validation->getErrors());
        }

    }

    public function getData()
    {
        return [
            [
                'input1' => 'required',
                [
                    ['input1' => ''],
                    ['input1' => ' '],
                    ['input1' => 0]
                ]
            ]
        ];
    }
}