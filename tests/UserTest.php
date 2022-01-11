<?php

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use App\Entity\User;
use App\Entity\Tasks;
use App\Controller\EmailSenderService;

class UserTest extends TestCase
{
    private User $user;
    private Tasks $task;
    private $emailSenderService;

    /*test settup class*/
    protected function setUp(): void
    {   
        $this->user = new User('seb', 'sso','seb@test.fr', 'password', Carbon::now()->subYears(22));
        $this->task = new Tasks('wash plates', 'you have to wash plates tomorrow', Carbon::now());

        /*emailSender mock test*/
        $this->emailSenderService = $this->getMockBuilder(EmailSenderService::class)
		->onlyMethods(['sendEmail'])
		->getMock();

        parent::setUp();
    }

    /*User test valid*/
    public function testUserIsValidNominal()
    {   
        $u = new User('seb', 'sso', 'seb@test.fr', 'password', Carbon::now()->subYears(20));
        $result = $u->isValid();
        $this->assertTrue($result);
    }

    /*test instance not valid*/
    public function testNotValidDueToFirstName()
    {
        $u = new User('', 'thomas', 'seb@test.fr','password', Carbon::now()->subYears(20));
        $result = $u->isValid();
        $this->assertFalse($result);
    }

    /*Name assert false test*/
    public function testNotValidDueToFName()
    {
        $this->user->setFirstname('');
        $this->assertFalse($this->user->isValid());
    }

    /*LastName assert false test*/
    public function testNotValidDueToLastName()
    {
        $this->user->setLastname('');
        $this->assertFalse($this->user->isValid());
    }

    /*Password assert false test*/
    public function testNotValidDueToPassword()
    {
        $this->user->setPassword('');
        $this->assertFalse($this->user->isValid());
    }

    /*Birthday in future test*/
    public function testNotValidDueToBirthdayInFuture()
    {
        $this->user->setBirthday(Carbon::now()->addDecade());
        $this->assertFalse($this->user->isValid());
    }

    /*Young user test*/
    public function testNotValidDueToTooYoungUser()
    {
        $this->user->setBirthday(Carbon::now()->subDecade());
        $this->assertFalse($this->user->isValid());
    }

    /*Valid email test*/
    public function testInValidEmail()
    {
        $this->user->setEmail('toto');
        $this->assertFalse($this->user->isValid());
    }

    /*Password number of carractere test*/
    public function testPasswordTooLong()
    {
        $this->user->setPassword('totojbffbjgfvfgjvgggjsvgjsjvfjsvjgfvfjgjsgfvjgsfvjgvjgsfgjsvfgjvsgjvbvjsbvjshbshvjh');
        $this->assertGreaterThan(40, strlen($this->user->getPassword()));
    }

    /*Short password test */
    public function testPasswordTooShort()
    {
        $this->user->setPassword('totojjv');
        $this->assertLessThan(8, strlen($this->user->getPassword()));
    }

    /*Users with taks test*/
    public function testGetTasks(): void
    {
        $task1=$this->task;
        $this->user->addTodolist($task1);
        $task1 = $this->user->getTodolist();
        $this->assertSame($task1, $this->user->getTodolist());
    }

    /*adding task test*/
    public function testAddTasks(): void
    {
        $task1=$this->task;
        $this->user->addTodolist($task1);
        $this->assertCount(1, $this->user->getTodolist());
    }

    /*removing task test*/
    public function testRemoveTasks(): void
    {
        $task1=$this->task;
        $this->user->addTodolist($task1);
        $this->user->removeTodolist($task1);
        $this->assertCount(0, $this->user->getTodolist());
    }

    /*Unique name task test*/
    public function testTasksTitleNotUnique(): void
    {
        $task1=new Tasks('wash plates', 'you have to wash plates tomorrow', Carbon::now());
        $this->user->addTodolist($task1);
        $task2=new Tasks('wash plates', 'you have to wash plates tomorrow', Carbon::now());
        $this->user->addTodolist($task2);
        $this->assertFalse($this->user->isUniqueTasksTitle());
        
    }

    /*tasks number test*/
    public function testTodolistLenghtLessThan10()
    {
         $this->assertTrue(sizeof($this->user->getTodolist()) < 10 );
    }

    /*mock emailSender test*/
    public function tesOfEmailSendAtEightItem(){
        if(sizeof($this->user->getTodolist()) == 8){
            $this->emailSenderService->expects($this->any())
            ->method('sendEmail')
            ->willThrowException(new Exception("You can add only 2 more task in your list"));
            $this->expectException(Exception::class);
        }
    }
}