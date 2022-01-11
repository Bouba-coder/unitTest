<?php

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use App\Entity\User;
use App\Entity\Tasks;


class TasksContentTest extends TestCase
{
    private Tasks $task;

    public function setUp(): void
    {
        $this->task = new Tasks('build house', 'build a big house', new \DateTime());
    }
    /*test assertInstanceOf*/
    public function testUsers()
    {
        $this->task->setAppUser(new User('mike', 'jordan', 'jordan@test.fr', 'passwordtest', Carbon::now()->subYears(20)));
        $this->assertInstanceOf(User::class, $this->task->getAppUser());
    }

    /*test count content carracteres*/
    public function testContentGreaterThanMax1000()
    {
        $this->task->setContent('Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of 
        classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at 
        Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum 
        passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem 
        Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero,
        written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, 
        "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.The standard chunk of Lorem Ipsum used since the 1500s is reproduced 
        below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact 
        original form, accompanied by English versions from the 1914 translation by H. Rackham.At vero eos et accusamus et iusto odio dignissimos 
        ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate 
        non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis 
        est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime 
        placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut 
        rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente 
        delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat');
        $this->assertGreaterThan(1000, strlen($this->task->getContent()));
    }

    /*test count less content number carracteres*/
    public function testContentLessThanMax1000()
    {
        $this->task->setContent('Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor');
        $this->assertLessThan(1000, strlen($this->task->getContent()));
    }

}