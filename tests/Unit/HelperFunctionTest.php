<?php

namespace Tests\Unit;

use Tests\TestCase;

class HelperFunctionTest extends TestCase {

    private $shortText;
    private $longText;
    
    public function setUp() {
        parent::setUp();
        $this->shortText = "Lorem Ipsum is simply dummy text of the printing";
        $this->longText = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
    }
    
    /**
     * @test
     */
    public function getSummaryOfLongText(){
        $summary = getSummary($this->longText,40);
        $this->assertLessThanOrEqual(strlen($summary), 35);
        
    }

}
