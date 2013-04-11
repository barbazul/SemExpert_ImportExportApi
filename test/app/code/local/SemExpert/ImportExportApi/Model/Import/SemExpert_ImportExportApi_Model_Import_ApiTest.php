<?php

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-04-11 at 20:28:07.
 */
class SemExpert_ImportExportApi_Model_Import_ApiTest extends PHPUnit_Framework_TestCase {

    /**
     * @var SemExpert_ImportExportApi_Model_Import_Api
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = Mage::getModel('importexportapi/import_api');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * @covers SemExpert_ImportExportApi_Model_Import_Api::validate
     */
    public function testValidate() {
        $str = uniqid();

        foreach (Mage::getModel('catalog/product')->getResource()->getEntityType()->getAttributeSetCollection() as $set) {
            break;
        }

        $required_attributes = array();

        foreach(Mage::getModel('eav/entity_attribute')->getCollection()->setAttributeSetFilter($set->getAttributeSetId()) as $attr) {
            if ($attr->getIsRequired()) {
                $required_attributes[] = $attr;
            }
        }

        ob_start();
        $out = fopen('php://output', 'w');
        $columns = array( '_type'  , '_attribute_set');
        $values = array(  'simple' , $set->getAttributeSetName());

        foreach ($required_attributes as $attr) {
            $columns[] = $attr->getAttributeCode();

            if ($attr->getSourceModel()) {
                $source = Mage::getModel($attr->getSourceModel());
                $options = $source->getAllOptions(false);
                $opt = end($options);
                $values[] = $opt['value'];
            } else {
                $values[] = $str;
            }
        }

        fputcsv($out, $columns);
        fputcsv($out, $values);
        fclose($out);

        $content = ob_get_clean();

        $file = new stdClass();
        $file->content = base64_encode($content);
        $file->mime = 'text/csv';

        try {
            $result = $this->object->validate($file);
            $this->assertEquals(1, $result->processed_rows_count);
            $this->assertEquals(0, $result->invalid_rows_count);
            $this->assertEquals(1, $result->processed_entities_count);
            $this->assertEquals(0, $result->errors_count);
        } catch (Mage_Api_Exception $e) {
            $this->fail($e->getCustomMessage());
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * @covers SemExpert_ImportExportApi_Model_Import_Api::start
     * @todo   Implement testStart().
     */
    public function testStart() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

}