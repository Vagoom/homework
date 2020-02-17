<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function getDocumentsAction(Request $request)
    {
        $documents = DB::table('documents')->get();
        return view('base', ['documents' => $documents]);
    }

    public function postDocumentAction(Request $request, Response $response) {

        $file = null;
        $validMimeTypes = ['application/pdf', 'application/x-pdf'];
        if ($request->hasFile('doc')) {

            $file = $request->file('doc');
            if (in_array($file->getMimeType(), $validMimeTypes)) {

                $filename = uniqid('doc_' . time() . '_') . '.pdf';
                $file->move('uploads', $filename);

                DB::table('documents')->insert([
                    'title' => $filename,
                    'file_path' => realpath('uploads' . DIRECTORY_SEPARATOR . $filename),
                    'file_url' => 'uploads' . DIRECTORY_SEPARATOR . $filename
                ]);

                return $response->setContent([
                    'status' => 'ok',
                    'message' => 'file successfully uploaded'
                ]);
            }
            else {
                return $response->setContent([
                    'status' => 'error',
                    'message' => 'upload a valid PDF document'
                ]);
            }
        }
        return $response->setContent([
            'status' => 'fail',
            'message' => 'file not sent'
        ]);
    }
}
