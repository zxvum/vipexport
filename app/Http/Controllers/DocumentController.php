<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\UserDocument;
use App\Models\UserDocumentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function documents()
    {
        $documents = Document::where('is_active', true)->orderBy('order', 'ASC')->get();
        $user_documents = UserDocument::where('user_id', auth()->user()->id)->get();
        $custom_documents = new Collection();

        foreach ($documents as $document) {
            $continue = false;
            foreach ($user_documents as $user_document){
                if ($user_document->document_id == $document->id){
                    $user_document->template_path = $document->template_path;
                    $user_document->example_path = $document->example_path;
                    $user_document->name = $document->name;

                    $custom_documents->push($user_document);
                    $continue = true;
                }
            }

            if ($continue){
                $continue = false;
                continue;
            }
            $custom_documents->push($document);
        }

        return view('documents', ['documents' => $custom_documents]);
    }

    public function downloadTemplate($file)
    {
        if (File::exists('storage/documents/'.$file)){
            $path = public_path() . '/storage/documents/' . $file;
            return Response::download($path, $file);
        } else {
            return abort(404);
        }
    }

    public function downloadDocument($file){
        if ($file != auth()->user()->document_path){
            return abort(404);
        }

        if(File::exists('storage/user_documents/'.$file)){
            $path = public_path() . '/storage/user_documents/' . $file;
            return Response::download($path, $file);
        } else {
            return abort(404);
        }
    }

    public function delete($document_id){
        $user_document = UserDocument::find($document_id);
        Storage::delete('/public/user_documents/'.$user_document->document_path);
        $user_document->delete();

        return redirect()->back()->with('document_delete_success', 'Документ успешно удален');
    }

    public function upload(Request $request, $document_id){
        $request->validate([
            'user_document_'.$document_id => 'required'
        ]);

        $document = Document::find($document_id);
        if (!$document){
            return abort(404);
        }

        $file = $request->file('user_document_'.$document_id);
        $filename = $document->name . ' ' . auth()->user()->id . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/user_documents/', $filename);

        UserDocument::create([
            'user_id' => auth()->user()->id,
            'document_id' => $document->id,
            'status_id' => 2,
            'document_path' => $filename
        ]);

        return redirect()->back()->with('document_upload_success', 'Документ успешно загружен и будет проверен в ближайшее время');
    }
}
