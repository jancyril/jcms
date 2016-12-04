<?php

namespace Janitor\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Janitor\Repositories\Files;
use Janitor\Helpers\FileUpload;
use Janitor\Http\Controllers\Controller;

class FilesController extends Controller
{
    /**
     * The property that will contain the Illuminate\Http\Request.
     *
     * @var object
     */
    protected $request;

    /**
     * The property that will contain the Janitor\Repositories\Files.
     *
     * @var object
     */
    private $file;

    /**
     * The property that will contain the Janitor\Helpers\FileUploader.
     *
     * @var object
     */
    private $upload;

    /**
     * The property that will contain a notice message.
     *
     * @var string
     */
    private $notice;

    /**
     * The property that will hold the value of the maximum file size.
     *
     * @var int
     */
    private $maxSize = 1000 * 1000 * 1;

    /**
     * The property that will contain the allowed file types.
     *
     * @var array
     */
    private $types = [];

    /**
     * Class constructor.
     *
     * @param object $file   Instance of Janitor\Repositories\Files
     * @param object $upload Instance of Janitor\Helpers\FileUploader
     */
    public function __construct(Files $file, FileUpload $upload)
    {
        $this->file = $file;
        $this->upload = $upload;
    }

    /**
     * This method will upload files.
     *
     * @param object $request Instance of Illuminate\Http\Request
     *
     * @return array
     */
    public function store(Request $request): array
    {
        if (empty($request->input('files'))) {
            return $this->error('No file has been selected');
        }

        $original = collect($request->input('files'));

        if (!$collection = $this->allowed($original)) {
            return $this->error('The file you are uploading is not allowed.', ['title' => 'Upload failed']);
        }

        if (!$collection = $this->validSize($collection)) {
            return $this->error('The file you are uploading is too large.', ['title' => 'Upload failed']);
        }

        return $this->filenames($collection, $original->count());
    }

    /**
     * This method will delete files.
     *
     * @param object     $request Instance of Illuminate\Http\Request
     * @param int|string $file    The file id or filename
     *
     * @return array
     */
    public function delete(Request $request, $file): array
    {
        if (!$file) {
            return $this->notifyInfo('No file has been deleted.', ['title' => 'Nothing happened']);
        }

        $key = is_numeric($file) ? 'id' : 'filename';

        $this->file->limit = 1;

        $entity = $this->file->findBy($key, $file);

        if (!$entity) {
            return $this->error('The file could not be found.', ['title' => 'Operation failed']);
        }

        $this->upload->remove($entity->first()->filename);
        $this->file->delete($entity->first()->id);

        return $this->success('The file has been successfully deleted.');
    }

    /**
     * Extracted method to check if file type is allowed.
     *
     * @param object $collection Collection of files
     *
     * @return bool|object
     */
    private function allowed(\Illuminate\Support\Collection $collection)
    {
        $files = $collection->filter(function ($file) {
            return $this->upload->isFileTypeAllowed($file, $this->types);
        });

        if ($files->isEmpty()) {
            return false;
        }

        return $files;
    }

    /**
     * Extracted method to check if the file size is allowed.
     *
     * @param object $collection Collection of files
     *
     * @return bool|object
     */
    private function validSize(\Illuminate\Support\Collection $collection)
    {
        $files = $collection->filter(function ($file) {
            return $this->maxSize >= $this->upload->getSize($file);
        });

        if ($files->isEmpty()) {
            return false;
        }

        return $files;
    }

    /**
     * Extracted method to save the file and persist to the database.
     *
     * @param object $collection Collection of files
     * @param int    $original
     *
     * @return object|mixed
     */
    private function filenames(\Illuminate\Support\Collection $collection, $original)
    {
        $count = $collection->count();

        $filenames = $collection->map(function ($file) {
            return $this->uploaded($file);
        });

        $this->unsuccessful($original, $count);

        return $filenames->prepend($this->notice)->toArray();
    }

    /**
     * Extracted method to return a notice if some files were
     * not successfully uploaded.
     *
     * @param int $original
     * @param int $count
     */
    private function unsuccessful($original, $count)
    {
        if ($original == $count) {
            return;
        }

        $missing = $original - $count;
        $word = str_plural('file', $missing);

        $this->notice['message'][] = [
            'result' => true,
            'type' => 'info',
            'title' => 'Heads up',
            'message' => "Unable to upload {$missing} {$word}, please try again.",
        ];
    }

    /**
     * Extracted method to save the file.
     *
     * @param object $file Instance of Symfony\Component\HttpFoundation\File\UploadedFile
     *
     * @return array
     */
    private function uploaded(\Symfony\Component\HttpFoundation\File\UploadedFile $file)
    {
        $name = $this->upload->getName($file);
        $filename = $this->upload->save($file);
        $creation = $this->upload->getCreationDate($file);

        $this->file->create(['name' => $name, 'filename' => $filename]);

        $this->notice['message'][] = $this->success("The file named  as {$name} has been successfully uploaded.");

        return ['id' => $this->file->id, 'name' => $name, 'filename' => $filename];
    }
}
