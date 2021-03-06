<?php


namespace App\Repositories;


use App\Exceptions\DatabaseException;
use App\Models\Document;

class DocumentRepository
{
    /**
     * @param string $filename
     * @param string $filePath
     * @param string $fileUrl
     * @return Document
     * @throws DatabaseException
     */
    public function saveFileInfo(string $filename, string $filePath, string $fileUrl): Document
    {
        $document = new Document();
        $document->title = $filename;
        $document->file_path = $filePath;
        $document->file_url = $fileUrl;

        $success = $document->save();
        if ($success === false) {
            throw new DatabaseException('File info not saved');
        }
        return $document;
    }
}
