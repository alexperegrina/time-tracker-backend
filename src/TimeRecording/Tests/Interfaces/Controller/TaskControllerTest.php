<?php
declare(strict_types=1);

namespace DegustaBox\TimeRecording\Tests\Interfaces\Controller;

use DateTime;
use DegustaBox\Auth\Domain\Entity\User;
use DegustaBox\Auth\Domain\Repository\UserRepository;
use DegustaBox\Core\Domain\Validator\SchemaValidator;
use DegustaBox\TimeRecording\Domain\Exception\NotTrackingInProcessException;
use DegustaBox\TimeRecording\Domain\Exception\TrackingInProcessException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    private DateTime $start;
    private DateTime $end;
    private KernelBrowser $client;
    private User $user;
    private SchemaValidator $schemaValidator;

    protected function setUp(): void
    {
        $this->start = new DateTime('2024-11-23 10:00:00');
        $this->end = new DateTime('2024-11-23 11:00:00');
        $this->client = static::createClient();
        $this->client->disableReboot();
        $userRepository = $this->client->getContainer()->get(UserRepository::class);
        $this->user = $userRepository->findByEmail('user@degustabox.com');
        $this->schemaValidator = $this->client->getContainer()->get(SchemaValidator::class);
    }

    public function testCreateTaskComplete(): void
    {
        $this->client->loginUser($this->user);

        $content = [
            'name' => 'task-test',
            'start' => $this->start->format(DATE_ATOM),
            'end' => $this->end->format(DATE_ATOM)
        ];

        $this->client->request('POST', '/api/time-recording/task/create', content: json_encode($content));
        $this->assertResponseStatusCodeSame(201);
    }

    public function testCreateTaskIncomplete(): void
    {
        $this->client->loginUser($this->user);

        $content = [
            'name' => 'task-test',
            'start' => $this->start->format(DATE_ATOM)
        ];

        $this->client->request('POST', '/api/time-recording/task/create', content: json_encode($content));
        $this->assertResponseStatusCodeSame(201);
    }

    public function testCreateTaskCompleteMultiple(): void
    {
        $this->client->loginUser($this->user);

        $content = [
            'name' => 'task-test',
            'start' => $this->start->format(DATE_ATOM),
            'end' => $this->end->format(DATE_ATOM)
        ];

        $this->client->request('POST', '/api/time-recording/task/create', content: json_encode($content));
        $this->assertResponseStatusCodeSame(201);

        $dt = $this->end;
        $dt->modify('+1 hour');
        $content = [
            'name' => 'task-test',
            'start' => $dt->format(DATE_ATOM),
            'end' => $dt->format(DATE_ATOM)
        ];

        $this->client->request('POST', '/api/time-recording/task/create', content: json_encode($content));
        $this->assertResponseStatusCodeSame(201);
    }

    public function testCreateTaskWithUnclosedOne(): void
    {
        $this->client->loginUser($this->user);

        $content = [
            'name' => 'task-test',
            'start' => $this->start->format(DATE_ATOM)
        ];

        $this->client->request('POST', '/api/time-recording/task/create', content: json_encode($content));
        $this->assertResponseStatusCodeSame(201);

        $content = [
            'name' => 'task-test',
            'start' => $this->end->format(DATE_ATOM),
        ];

        $this->client->request('POST', '/api/time-recording/task/create', content: json_encode($content));
        $this->assertResponseStatusCodeSame(202);

        $expected = [
            'code' => 202,
            'exception' => TrackingInProcessException::class,
            'message' => 'Tracking in process'
        ];
        $this->assertJsonStringEqualsJsonString($this->client->getResponse()->getContent(), json_encode($expected));
    }

    public function testCloseTask(): void
    {
        $this->client->loginUser($this->user);

        $content = [
            'name' => 'task-test',
            'start' => $this->start->format(DATE_ATOM)
        ];

        $this->client->request('POST', '/api/time-recording/task/create', content: json_encode($content));
        $this->assertResponseStatusCodeSame(201);

        $content = [
            'name' => 'task-test',
            'end' => $this->end->format(DATE_ATOM)
        ];

        $this->client->request('POST', '/api/time-recording/task/close', content: json_encode($content));
        $this->assertResponseStatusCodeSame(201);
    }

    public function testCloseNotTrackingInProcessException(): void
    {
        $this->client->loginUser($this->user);

        $content = [
            'name' => 'task-test',
            'start' => $this->start->format(DATE_ATOM),
            'end' => $this->end->format(DATE_ATOM)
        ];

        $this->client->request('POST', '/api/time-recording/task/create', content: json_encode($content));
        $this->assertResponseStatusCodeSame(201);

        $content = [
            'name' => 'task-test',
            'end' => $this->end->format(DATE_ATOM)
        ];

        $this->client->request('POST', '/api/time-recording/task/close', content: json_encode($content));
        $this->assertResponseStatusCodeSame(202);

        $expected = [
            'code' => 202,
            'exception' => NotTrackingInProcessException::class,
            'message' => 'Not tracking in process'
        ];
        $this->assertJsonStringEqualsJsonString($this->client->getResponse()->getContent(), json_encode($expected));
    }

    public function testList(): void
    {
        $this->client->loginUser($this->user);

        $content = [
            'name' => 'task-test',
            'start' => $this->start->format(DATE_ATOM),
            'end' => $this->end->format(DATE_ATOM)
        ];

        $this->client->request('POST', '/api/time-recording/task/create', content: json_encode($content));
        $this->assertResponseStatusCodeSame(201);

        $this->client->request('GET', '/api/time-recording/task/list', content: json_encode($content));
        $response = $this->client->getResponse()->getContent();

        $this->schemaValidator->validate(
            json_decode($response, true),
            '@TimeRecordingBundle/Resources/schema/Interfaces/Controller/TaskController/Response/list.json'
        );
    }
}