<?php

namespace App\Http\Controllers;

use App\Exceptions\DatabaseException;
use App\Models\Document;
use App\Services\DocumentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class Controller extends BaseController
{
    /** @var DocumentService */
    private $documentService;

    /**
     * Controller constructor.
     * @param DocumentService $documentService
     */
    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    /**
     * @param Request $request
     * @return View
     */
    public function getDocumentsAction(Request $request)
    {
        return view('base', ['documents' => Document::paginate(20)]);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function postDocumentAction(Request $request, Response $response)
    {
        try {
            $this->validate($request, [Document::FILE_FORM_FIELD => 'required|mimes:pdf']);
            $savedDocument = $this->documentService->uploadDocument($request->file(Document::FILE_FORM_FIELD));

            return $response->setContent($this->documentService->buildResponseBody($savedDocument));

        } catch (FileException | DatabaseException $e) {
            return $response->setContent([
                'status' => 'fail',
                'message' => $e->getMessage()
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (ValidationException $e) {
            return $response->setContent([
                'status' => 'error',
                'message' => $e->getMessage()
            ])->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }
}
