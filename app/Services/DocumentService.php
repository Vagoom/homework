<?php


namespace App\Services;


use App\Exceptions\DatabaseException;
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
     * @throws DatabaseException
     * @throws FileException
     */
    public function uploadDocument(UploadedFile $doc)
    {
        $filename = uniqid('doc_' . time() . '_') . '.pdf';
        $doc->move(self::UPLOAD_FOLDER, $filename);
        $this->documentRepository->saveFileInfo(
            $filename,
            realpath(self::UPLOAD_FOLDER . DIRECTORY_SEPARATOR . $filename),
            self::UPLOAD_FOLDER . DIRECTORY_SEPARATOR . $filename
        );
    }
}
