<?php

use App\Classes\Importer;

class ImporterTest extends TestCase
{
    /**
     * Test if the Importer startImport method will return ['result'=>false, ... ]
     * if the count parameter is less than the minimum (100).
     *
     * @return void
     */
    public function testErrorOnBelowMinimum()
    {
        $importer = new Importer(1);
        $result = $importer->startImport();

        $this->assertEquals($result->result, false);
    }

    /**
     * Test the importing process will return ['result'=>true, ...] if success
     * This will use in-memory database sqlite.
     *
     * @return void
     */
    public function testImporting()
    {
        $importer = new Importer(100);
        $result = $importer->startImport();
        $this->assertEquals($result->result, true);
    }
}
