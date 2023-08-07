<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\{TaskStatus, User};

class TaskStatusControllerTest extends TestCase
{
    private User $user;
    private TaskStatus $taskStatus;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->taskStatus = TaskStatus::factory()->create();
    }
    public function testIndex(): void
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('task_statuses.create'));
        $response->assertOk();
    }

    public function testEdit(): void
    {
        $response = $this->actingAs($this->user)->get(route('task_statuses.edit', $this->taskStatus));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $data = TaskStatus::factory()->make()->only('name');
        $response = $this->actingAs($this->user)->post(route('task_statuses.store', $data));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testUpdate(): void
    {
        $data = TaskStatus::factory()->make()->only('name');
        $response = $this->actingAs($this->user)->patch(route('task_statuses.update', $this->taskStatus), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testDelete(): void
    {
        $response = $this->actingAs($this->user)->delete(route('task_statuses.destroy', $this->taskStatus));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseMissing('task_statuses', ['id' => (array) $this->taskStatus['id']]);
    }
}
