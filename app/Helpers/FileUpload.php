<?php

namespace Janitor\Helpers;

use Storage;

class FileUpload
{
    /**
     * The file types that are allowed to be uploaded.
     *
     * @var array
     */
    private $fileTypes = ['jpeg', 'jpg', 'png', 'gif', 'csv', 'mp4', 'avi'];

    /**
     * This method will check if the file type
     * being uploaded is allowed or not.
     *
     * @param object $file  The file being uploaded
     * @param array  $types Additional file types to be supported
     *
     * @return bool
     */
    public function isFileTypeAllowed($file, $types = [])
    {
        $allowed = array_merge($this->fileTypes, $types);

        if (!in_array($this->getExtension($file), $allowed)) {
            return false;
        }

        return true;
    }

    /**
     * This method will get the original name of the uploaded file.
     *
     * @param object $file The file being uploaded
     *
     * @return string
     */
    public function getName($file)
    {
        return $file->getClientOriginalName();
    }

    /**
     * This method will get the file extension.
     *
     * @param object $file The file being uploaded
     *
     * @return string
     */
    public function getExtension($file)
    {
        return strtolower($file->getClientOriginalExtension());
    }

    /**
     * This method will get the mime type of the file.
     *
     * @param object $file The file being uploaded
     *
     * @return string
     */
    public function getMimeType($file)
    {
        return $file->getClientMimeType();
    }

    /**
     * This method will get the hash name of a file.
     *
     * @param object $file The file being uploaded
     *
     * @return string
     */
    public function getHashed($file)
    {
        return hash_file('md5', $file);
    }

    /**
     * This method will get the file size.
     *
     * @param object $file The file being uploaded
     *
     * @return int
     */
    public function getSize($file)
    {
        return (int) $file->getClientSize();
    }

    /**
     * This method will save the uploaded file to the storage.
     *
     * @param object $file The file being uploaded
     *
     * @return string
     */
    public function save($file)
    {
        $filename = $this->generateName($file);

        Storage::put(config('custom.upload_path').$filename, file_get_contents($file));

        return $filename;
    }

    /**
     * This method will remove a file from the storage.
     *
     * @param object $file The filename to be removed
     *
     * @return bool|void
     */
    public function remove($file)
    {
        if (!Storage::has(config('custom.upload_path').$file)) {
            return false;
        }

        return Storage::delete(config('custom.upload_path').$file);
    }

    /**
     * This method will generate a unique filename for the file.
     *
     * @param object $file The file being uploaded
     *
     * @return string
     */
    private function generateName($file)
    {
        return date('YHismd').str_random(5).$this->getHashed($file).'.'.$this->getExtension($file);
    }
}
