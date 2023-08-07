<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\{User, Label};

class LabelControllerTest extends TestCase
{
    private User $user;
    private Label $label;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->label = Label::factory()->create();
    }
    public function testIndex(): void
    {
        $response = $this->get(route('labels.index'));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('labels.create'));
        $response->assertOk();
    }

    public function testEdit(): void
    {
        $response = $this->actingAs($this->user)->get(route('labels.edit', $this->label));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $data = Label::factory()->make()->only('name', 'description');
        $response = $this->actingAs($this->user)->post(route('labels.store', $data));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('labels', $data);
    }

    public function testUpdate(): void
    {
        $data = Label::factory()->make()->only('name', 'description');
        $response = $this->actingAs($this->user)->patch(route('labels.update', $this->label), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('labels', $data);
    }

    public function testDelete(): void
    {
        $response = $this->actingAs($this->user)->delete(route('labels.destroy', $this->label));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseMissing('labels', ['id' => (array) $this->label['id']]);
    }
}
