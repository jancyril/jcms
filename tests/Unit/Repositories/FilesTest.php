<?php

namespace Test\Unit\Repositories;

use Tests\TestCase;
use Janitor\Repositories\Files;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FilesTest extends TestCase
{
    use DatabaseTransactions;

    /** @test  **/
    public function it_can_add_new_file()
    {
        $data = $this->make();

        $file = new Files();

        $file->create($data);

        $this->assertDatabaseHas('files', ['id' => $file->id]);
    }

    /** @test  **/
    public function it_can_update_a_record_of_file()
    {
        $record = $this->create();

        $file = new Files();

        $file->update($record->id, ['name' => 'Image']);

        $this->assertDatabaseHas('files', ['id' => $record->id, 'name' => 'Image']);
    }

    /** @test  **/
    public function it_can_delete_a_record_of_file()
    {
        $record = $this->create();

        $file = new Files();

        $file->delete($record->id);

        $this->assertDatabaseMissing('files', ['id' => $record->id]);
    }

    private function make()
    {
        return factory(\Janitor\Models\File::class)->make()->toArray();
    }

    private function create(array $overrides = [])
    {
        return factory(\Janitor\Models\File::class)->create($overrides);
    }
}
