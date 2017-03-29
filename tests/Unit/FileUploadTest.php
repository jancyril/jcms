<?php

namespace Test\Unit;

use Tests\TestCase;
use Janitor\Helpers\FileUpload as File;
use VirtualFileSystem\FileSystem as Vfs;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploadTest extends TestCase
{
    /** @test  **/
    public function it_can_get_the_generated_hash_name_of_the_file()
    {
        $vfs = new Vfs();

        file_put_contents($vfs->path('/jcms.csv'), 'Hello World');

        $tempFile = new UploadedFile($vfs->path('/jcms.csv'), 'jcms.csv');

        $file = new File();

        $hash = $file->getHashed($tempFile);

        $this->assertEquals($hash, hash_file('md5', $tempFile));
    }

    /** @test  **/
    public function it_can_get_the_file_size()
    {
        $uploaded = $this->mockFile();

        $file = new File();

        $size = $file->getSize($uploaded);

        $this->assertTrue(is_int($size));
    }

    /** @test  **/
    public function it_can_check_if_file_extension()
    {
        $uploaded = $this->mockFile();

        $file = new File();

        $ext = $file->getExtension($uploaded);

        $this->assertEquals('jpg', $ext);
    }

    /** @test  **/
    public function it_can_get_the_file_mime_type()
    {
        $uploaded = $this->mockFile();

        $file = new File();

        $mime = $file->getMimeType($uploaded);

        $this->assertEquals('image/jpeg', $mime);
    }

    /** @test  **/
    public function it_can_check_if_file_type_is_allowed()
    {
        $uploaded = $this->mockFile();

        $file = new File();

        $allowed = $file->isFileTypeAllowed($uploaded);

        $this->assertTrue($allowed);

        $uploaded1 = $this->mockFile($name = 'file.php', $ext = 'php');

        $allowed = $file->isFileTypeAllowed($uploaded1);

        $this->assertFalse($allowed);
    }

    /** @test  **/
    public function it_can_add_additional_file_types()
    {
        $uploaded = $this->mockFile($name = 'file.doc', $ext = 'doc');

        $file = new File();

        $allowed = $file->isFileTypeAllowed($uploaded, ['doc']);

        $this->assertTrue($allowed);
    }

    /** @test  **/
    public function it_can_get_the_original_file_name()
    {
        $uploaded = $this->mockFile();

        $file = new File();

        $name = $file->getName($uploaded);

        $this->assertEquals('image.jpg', $name);
    }

    /** @test  **/
    public function it_can_save_the_file()
    {
        $vfs = new Vfs();

        file_put_contents($vfs->path('/jcms.csv'), 'Hello World');

        $file = new File();

        $tempFile = new UploadedFile($vfs->path('/jcms.csv'), 'jcms.csv');

        $filename = $file->save($tempFile);

        $this->assertFileExists(config('custom.asset_path').config('custom.upload_path').$filename);

        $file->remove($filename);
    }

    /** @test  **/
    public function it_can_remove_a_file()
    {
        $vfs = new Vfs();

        file_put_contents($vfs->path('/jcms.csv'), 'Hello World');

        $file = new File();

        $tempFile = new UploadedFile($vfs->path('/jcms.csv'), 'jcms.csv');

        $filename = $file->save($tempFile);

        $this->assertFileExists(config('custom.asset_path').config('custom.upload_path').$filename);

        $file->remove($filename);

        $this->assertFileNotExists(config('custom.asset_path').config('custom.upload_path').$filename);
    }

    /** @test  **/
    public function it_can_get_the_creation_or_modification_date_of_a_file()
    {
        $vfs = new Vfs();

        file_put_contents($vfs->path('/jcms.csv'), 'Hello World');

        $tempFile = new UploadedFile($vfs->path('/jcms.csv'), 'jcms.csv');

        $file = new File();

        $result = $file->getCreationDate($tempFile);

        $created = \Carbon\Carbon::createFromTimestamp(filemtime($tempFile))->format('Y-m-d H:i:s');

        $this->assertEquals($created, $result);
    }

    private function mockFile($name = 'image.jpg', $ext = 'jpg', $size = '1024', $mime = 'image/jpeg')
    {
        return \Mockery::mock(
            Symfony\Component\HttpFoundation\File\UploadedFile::class,
            [
                'getClientOriginalName' => $name,
                'getClientOriginalExtension' => $ext,
                'getClientSize' => $size,
                'getClientMimeType' => $mime,
            ]
        );
    }
}
