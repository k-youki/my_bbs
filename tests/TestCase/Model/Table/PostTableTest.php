<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PostTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PostTable Test Case
 */
class PostTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PostTable
     */
    public $PostTable;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Post') ? [] : ['className' => 'App\Model\Table\PostTable'];
        $this->PostTable = TableRegistry::get('Post', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PostTable);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
