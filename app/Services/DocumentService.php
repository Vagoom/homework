<?php


namespace App\Services;


use App\Exceptions\DatabaseException;
use App\Models\Document;
use App\Repositories\DocumentRepository;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class DocumentService
{
    const UPLOAD_FOLDER = 'uploads';

    /** @var DocumentRepository */
    private $documentRepository;

    /**
     * DocumentService constructor.
     * @param DocumentRepository $documentRepository
     */
    public function __construct(DocumentRepository $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }

    /**
     * @param UploadedFile $doc
     * @return Document
     * @throws DatabaseException
     * @throws FileException
     */
    public function uploadDocument(UploadedFile $doc)
    {
        $filename = uniqid('doc_' . time() . '_') . '.pdf';
        $doc->move(self::UPLOAD_FOLDER, $filename);
        return $this->documentRepository->saveFileInfo(
            $filename,
            realpath(self::UPLOAD_FOLDER . DIRECTORY_SEPARATOR . $filename),
            self::UPLOAD_FOLDER . DIRECTORY_SEPARATOR . $filename
        );
    }

    /**
     * @param Document $document
     * @return array
     */
    public function buildResponseBody(Document $document)
    {
        return [
            'status' => 'ok',
            'message' => 'file successfully uploaded',
            'docId' => $document->id,
            'docTitle' => $document->title,
            'docUrl' => $document->file_url
        ];
    }
}
