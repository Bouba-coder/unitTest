<?php

namespace App\Test;

use App\Entity\Tasks;
use App\Controller\TasksController;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    //private variable task
    private Tasks $ta;
    private TasksController $taController;

    //setup
    protected function setUp(): void
    {
        $this->ta = new Tasks('build house', 'build a big house', new \DateTime());
        $this->taController = new TasksController();

        parent::setUp();
    }
    //test id getter//
    public function testId(): void
    {
        $this->assertNull($this->ta->getId());
    }

    /*assert same test for CreatedAt setter getter*/
    public function testCreatedAt()
    {
         $date = new \DateTime();
         $this->ta->setCreateDate($date);
         $this->assertSame($date, $this->ta->getCreateDate());
    }

    /*assert same test for Name setter getter*/
    public function testName()
    {
         $this->ta->setName('New Tasks');
         $this->assertSame('New Tasks', $this->ta->getName());
    }

    /*assert same test for  Content setter getter*/
    public function testContent()
    {
         $this->ta->setContent('Content of the task');
         $this->assertSame('Content of the task', $this->ta->getContent());
    }

    /*test empty name*/
    public function testNotValidEmptyName()
    {
        $this->ta->setName("");
        $this->assertFalse($this->ta->isValidName());
    }

    /*Not empty name*/
    public function testValidName()
    {
        $this->ta->setName("Boubacar");
        $this->assertTrue($this->ta->isValidName());
    }

    /*Empty content*/
    public function testNotValidEmptyContent()
    {
         $this->ta->setContent("");
         $this->assertFalse($this->ta->isValidContent());
    }
    /*Not empty content*/
    public function testValidContent()
    {
         $this->ta->setContent("Content of the task");
         $this->assertTrue($this->ta->isValidContent());
    }


    /*Test d'assertion type equals setter getter*/
    public function testAssertionTaskCreateName()
    {
        $this->ta->setName("Name");
        $this->assertEquals("Name", $this->ta->getName());
    }

    /*assertion type equals Content*/
    public function testAssertionTaskCreateContent(){
        $this->ta->setContent("Ceci est un test");
        $this->assertEquals("Ceci est un test", $this->ta->getContent());
    }

    /*assertion type equals date*/
    public function testAssertionTaskCreateDate()
    {
        $date = new \DateTime('@'.strtotime('now'));
        $this->ta->setCreateDate($date);
        $this->assertEquals($date, $this->ta->getCreateDate());
    }
    /*assertion type equals id_users*/
    public function testAssertionTaskCreateIdUsers(){
        $this->ta->setIdUsers(1);
        $this->assertEquals(1, $this->ta->getIdUsers());
    }

    /*add itemtime function test*/
    public function testTimeAddItem()
    {
        //$this->ta->setCreateDate(new \DateTime());
        $this->ta->setCreateDate(new \DateTime('2013-06-19 18:25'));
        //$this->assertEquals($this->ta->getCreateDate(), $this->ta->getCreateDate());
        $this->assertEquals('22', $this->taController->checkAddTime('06/19/13 21:47', $this->ta->getCreateDate()));
    }

}