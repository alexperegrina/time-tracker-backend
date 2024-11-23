<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Tests\Interfaces\Controller;

use DateTime;
use DegustaBox\Auth\Domain\Entity\User;
use DegustaBox\Auth\Domain\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    private DateTime $dateTime;
    private KernelBrowser $client;
    private User $user;

    protected function setUp(): void
    {
        $this->dateTime = new DateTime();
        $this->client = static::createClient();
        $this->client->disableReboot();
        $userRepository = $this->client->getContainer()->get(UserRepository::class);
        $this->user = $userRepository->findByEmail('user@degustabox.com');
    }

    public function testCreateTaskComplete(): void
    {
        $this->client->loginUser($this->user);

        $content = [
            'name' => 'task-test',
            'start' => $this->dateTime->format('Y-m-d H:i:s'),
            'end' => $this->dateTime->format('Y-m-d H:i:s')
        ];

        $this->client->request('POST', '/api/time-recording/task/create', content: json_encode($content));
        $this->assertResponseStatusCodeSame(201);
    }

    public function testCreateTaskIncomplete(): void
    {
        $this->client->loginUser($this->user);

        $content = [
            'name' => 'task-test',
            'start' => $this->dateTime->format('Y-m-d H:i:s')
        ];

        $this->client->request('POST', '/api/time-recording/task/create', content: json_encode($content));
        $this->assertResponseStatusCodeSame(201);
    }

    public function testCreateTaskCompleteMultiple(): void
    {
        $this->client->loginUser($this->user);

        $content = [
            'name' => 'task-test',
            'start' => $this->dateTime->format('Y-m-d H:i:s'),
            'end' => $this->dateTime->format('Y-m-d H:i:s')
        ];

        $this->client->request('POST', '/api/time-recording/task/create', content: json_encode($content));
        $this->assertResponseStatusCodeSame(201);

        $dt = $this->dateTime->modify('+1 hour');
        $content = [
            'name' => 'task-test',
            'start' => $dt->format('Y-m-d H:i:s'),
            'end' => $dt->format('Y-m-d H:i:s')
        ];

        $this->client->request('POST', '/api/time-recording/task/create', content: json_encode($content));
        $this->assertResponseStatusCodeSame(201);
    }

    public function testCreateTaskWithUnclosedOne(): void
    {
        $this->client->loginUser($this->user);

        $content = [
            'name' => 'task-test',
            'start' => $this->dateTime->format('Y-m-d H:i:s')
        ];

        $this->client->request('POST', '/api/time-recording/task/create', content: json_encode($content));
        $this->assertResponseStatusCodeSame(201);

        $dt = $this->dateTime->modify('+1 hour');
        $content = [
            'name' => 'task-test',
            'start' => $dt->format('Y-m-d H:i:s'),
        ];

        $this->client->request('POST', '/api/time-recording/task/create', content: json_encode($content));
        $this->assertResponseStatusCodeSame(202);

        $expected = ['message' => 'Tracking in process'];
        $this->assertJsonStringEqualsJsonString($this->client->getResponse()->getContent(), json_encode($expected));
    }

    public function testCloseTask(): void
    {
        $this->client->loginUser($this->user);

        $content = [
            'name' => 'task-test',
            'start' => $this->dateTime->format('Y-m-d H:i:s')
        ];

        $this->client->request('POST', '/api/time-recording/task/create', content: json_encode($content));
        $this->assertResponseStatusCodeSame(201);

        $content = [
            'name' => 'task-test',
            'end' => $this->dateTime->format('Y-m-d H:i:s')
        ];

        $this->client->request('POST', '/api/time-recording/task/close', content: json_encode($content));
        $this->assertResponseStatusCodeSame(201);
    }

    public function testCloseNotTrackingInProcessException(): void
    {
        $this->client->loginUser($this->user);

        $content = [
            'name' => 'task-test',
            'start' => $this->dateTime->format('Y-m-d H:i:s'),
            'end' => $this->dateTime->format('Y-m-d H:i:s')
        ];

        $this->client->request('POST', '/api/time-recording/task/create', content: json_encode($content));
        $this->assertResponseStatusCodeSame(201);

        $content = [
            'name' => 'task-test',
            'end' => $this->dateTime->format('Y-m-d H:i:s')
        ];

        $this->client->request('POST', '/api/time-recording/task/close', content: json_encode($content));
        $this->assertResponseStatusCodeSame(202);

        $expected = ['message' => 'Not tracking in process'];
        $this->assertJsonStringEqualsJsonString($this->client->getResponse()->getContent(), json_encode($expected));
    }
}