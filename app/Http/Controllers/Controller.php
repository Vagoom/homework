<?php

namespace App\Http\Controllers;

use App\Repositories\DocumentRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /** @var DocumentRepository */
    private $documentRepository;

    /**
     * Controller constructor.
     * @param DocumentRepository $documentRepository
     */
    public function __construct(DocumentRepository $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }

    public function getDocumentsAction(Request $request)
    {
        return view('base', [
            'documents' => $this->documentRepository->findAll()
        ]);
    }

    public function postDocumentAction(Request $request, Response $response)
    {
        try {
            $this->validate($request, ['doc' => 'required|mimes:pdf']);
        } catch (ValidationException $e) {
            return $response->setContent([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
        $fileFromRequest = $request->file('doc');
        $filename = uniqid('doc_' . time() . '_') . '.pdf';
        $fileFromRequest->move('uploads', $filename);

        if ($this->documentRepository->saveFile($filename) === true) {
            return $response->setContent([
                'status' => 'ok',
                'message' => 'file successfully uploaded'
            ]);
        }
        return $response->setContent([
            'status' => 'fail',
            'message' => 'something went wrong'
        ]);
    }
}
