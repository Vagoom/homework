<?php


namespace App\Repositories;


use Illuminate\Support\Facades\DB;

class DocumentRepository
{
    const UPLOAD_FOLDER = 'uploads';

    public function findAll()
    {
        return DB::table('documents')->get();
    }

    /**
     * @param string $filename
     * @return bool
     */
    public function saveFile($filename)
    {
        return DB::table('documents')->insert([
            'title' => $filename,
            'file_path' => realpath(self::UPLOAD_FOLDER . DIRECTORY_SEPARATOR . $filename),
            'file_url' => self::UPLOAD_FOLDER . DIRECTORY_SEPARATOR . $filename
        ]);
    }
}
