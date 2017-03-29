<?php

namespace Test\Feature\Admin;

use Tests\TestCase;
use VirtualFileSystem\FileSystem as Vfs;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FilesControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test  **/
    public function it_will_not_proceed_if_file_type_is_not_allowed()
    {
        $this->admin();

        $this->post(route('admin::post-file'), ['files' => [$this->file('sample.mov')]])
            ->assertSee('error')
            ->assertStatus(200);
    }

    /** @test  **/
    public function it_will_not_proceed_if_file_size_exceeds_the_allowable_limit()
    {
        $this->admin();

        $this->post(route('admin::post-file'), ['files' => [$this->file('sample.jpg', 1024 * 1024 * 100)]])
            ->assertSee('error')
            ->assertStatus(200);
    }

    /** @test  **/
    public function it_will_succeed_if_all_above_conditions_are_met()
    {
        $vfs = new Vfs();

        file_put_contents($vfs->path('/sample.jpg'), '');

        $file = new UploadedFile($vfs->path('/sample.jpg'), 'sample.jpg');

        $admin = $this->admin();

        $this->post(route('admin::post-file'), ['files' => [$file]])
            ->assertSee('sample.jpg')
            ->assertSee('Success')
            ->assertStatus(200);
    }

    /** @test  **/
    public function it_can_receive_multiple_files_at_a_time()
    {
        $vfs = new Vfs();

        file_put_contents($vfs->path('/sample.csv'), 'Hello');

        file_put_contents($vfs->path('/photo.csv'), 'Hello World');

        $files[] = new UploadedFile($vfs->path('/sample.csv'), 'sample.csv');

        $files[] = new UploadedFile($vfs->path('/photo.csv'), 'photo.csv');

        $this->admin();

        $this->post(route('admin::post-file'), ['files' => $files])
            ->assertSee('sample.csv')
            ->assertSee('photo.csv')
            ->assertSee('Success')
            ->assertStatus(200);
    }

    /** @test  **/
    public function it_can_continue_multiple_files_upload_even_one_file_failed()
    {
        $vfs = new Vfs();

        file_put_contents($vfs->path('/sample.csv'), 'Hello World');

        file_put_contents($vfs->path('/sample.php'), 'Hello World');

        file_put_contents($vfs->path('/photo.csv'), 'Hey');

        $files[] = new UploadedFile($vfs->path('/sample.csv'), 'sample.csv');

        $files[] = new UploadedFile($vfs->path('/sample.php'), 'sample.php');

        $files[] = new UploadedFile($vfs->path('/photo.csv'), 'photo.csv');

        $admin = $this->admin();

        $this->post(route('admin::post-file'), ['files' => $files])
            ->assertSee('sample.csv')
            ->assertSee('photo.csv')
            ->assertDontSee('sample.php')
            ->assertSee('Success')
            ->assertStatus(200);
    }

    /** @test  **/
    public function it_should_return_a_notice_if_one_or_more_files_were_not_uploaded()
    {
        $vfs = new Vfs();

        file_put_contents($vfs->path('/sample.csv'), 'Hello World');

        file_put_contents($vfs->path('/sample.php'), 'Hello World');

        file_put_contents($vfs->path('/photo.csv'), 'Hey');

        $files[] = new UploadedFile($vfs->path('/sample.csv'), 'sample.csv');

        $files[] = new UploadedFile($vfs->path('/sample.php'), 'sample.php');

        $files[] = new UploadedFile($vfs->path('/photo.csv'), 'photo.csv');

        $admin = $this->admin();

        $response = $this->post(route('admin::post-file'), ['files' => $files])
                        ->assertSee('sample.csv')
                        ->assertSee('photo.csv')
                        ->assertDontSee('sample.php')
                        ->assertSee('Success')
                        ->assertStatus(200);
    }

    /** @test  **/
    public function it_can_delete_a_file()
    {
        $vfs = new Vfs();

        file_put_contents($vfs->path('/data.csv'), 'Hey there');

        $file = new UploadedFile($vfs->path('/data.csv'), 'data.csv');

        $this->admin();

        $result = $this->post(route('admin::post-file'), ['files' => [$file]]);

        $id = $result->original[1]['id'];

        $this->delete(route('admin::delete-file', ['id' => $id]))
            ->assertSee('Success')
            ->assertStatus(200);
    }

    /** @test  **/
    public function it_can_delete_a_file_via_filename()
    {
        $vfs = new Vfs();

        file_put_contents($vfs->path('/data.csv'), 'Hey there');

        $file = new UploadedFile($vfs->path('/data.csv'), 'data.csv');

        $this->admin();

        $result = $this->post(route('admin::post-file'), ['files' => [$file]]);

        $this->delete(route('admin::delete-file', ['file' => $result->original[1]['filename']]))
            ->assertSee('Success')
            ->assertStatus(200);
    }

    public function tearDown()
    {
        exec('rm -rf '.config('custom.asset_path').config('custom.upload_path'));
    }

    private function admin()
    {
        $user = factory(\Janitor\Models\User::class)->create();

        $this->actingAs($user);

        return $user;
    }

    private function file($filename = 'sample.jpg', $size = 1000 * 1000 * 1, $mime = 'application/octet-stream')
    {
        $vfs = new Vfs();

        file_put_contents($vfs->path('/'.$filename), '');

        $file = new UploadedFile($vfs->path('/'.$filename), $filename, $mime, $size);

        return $file;
    }
}
