<?php

namespace Tests\Tools;

use PROJ\Tools\Template;

/**
 * Description of TemplateTest
 *
 * @author Patrick
 */
class TemplateTest extends \PHPUnit_Framework_TestCase {

    /**
     * @expectedException \Exception
     */
    public function testInvalidViewFile() {
        new Template("NonExistingViewFile");
    }

    public function testTemplateMagicMethods() {
        $value = "schaap";
        $t = new Template("Partial" . DS . "BottomJsIncludes");
        $t->blaat = $value;

        $this->assertEquals($t->blaat, $value);
    }

}
