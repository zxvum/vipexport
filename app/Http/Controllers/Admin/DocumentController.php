<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    // MAIN IN DOCUMENTS
    public function all(){
        $documents = Document::orderBy('order', 'ASC')->get();

        return view('admin.documents.table', ['documents' => $documents]);
    }

    public function updateOrder(Request $request){
        $documents = Document::all();

        foreach ($documents as $document) {
            $document->timestamps = false; // To disable update_at field updation
            $id = $document->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $document->update(['order' => $order['position']]);
                }
            }
        }

        return response('Update Successfully.', 200);
    }

    public function createView(){
        return view('admin.documents.create');
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string']
        ]);

        if ($validator->fails()){
            session()->put(['data' => ['name' => $request->name]]);
            return redirect()->back()->withErrors($validator);
        }

        $document = new Document();
        $document->name = $request->name;

        if ($request->has('template_file')) {
            $file = $request->file('template_file');
            $filename = $file->getClientOriginalName();
            $file->storeAs('public/documents/', $filename);

            $document->template_file = $filename;
        }

        if ($request->has('example_file')) {
            $file = $request->file('example_file');
            $filename = $file->getClientOriginalName();
            $file->storeAs('public/documents/', $filename);

            $document->example_file = $filename;
        }

        if ($request->is_active == 'on'){
            $document->is_active = true;
        } else {
            $document->is_active = false;
        }
        $document->order = Document::orderBy('order', 'DESC')->first()->order + 1;
        $document->save();

        return to_route('admin.documents.all')->with('document_create_success', 'Документ: '.$request->name.' успешно создан');
    }

    public function editView($id){
        $document = Document::find($id);
        return view('admin.documents.edit', ['document' => $document]);
    }

    public function edit($id, Request $request){
        $document = Document::find($id);
        if (!$document){
            return abort(404);
        }

        $request->validate(['name' => 'required']);

        $document->name = $request->name;

        if ($request->has('template_file')) {
            $file = $request->file('template_file');
            $filename = $file->getClientOriginalName();
            $file->storeAs('public/documents/', $filename);

            $document->template_file = $filename;
        }

        if ($request->has('example_file')) {
            $file = $request->file('example_file');
            $filename = $file->getClientOriginalName();
            $file->storeAs('public/documents/', $filename);

            $document->example_file = $filename;
        }

        if ($request->is_active == 'on'){
            $document->is_active = true;
        } else {
            $document->is_active = false;
        }
        $document->save();

        return redirect()->back()->with('document_edit_success', 'Документ: '.$request->name.' успешно изменен');
    }

    public function delete($id){
        $document = Document::find($id);
        if (!$document){
            return abort(404);
        }
        $name = $document->name;
        $document->delete();

        return redirect()->back()->with('document_delete_success', 'Документ: '.$name.' успешно изменен');
    }

    public function deleteTemplate($id){
        $document = Document::find($id);
        if (!$document){
            return abort(404);
        }

        Storage::delete('documents/'.$document->template_file);
        $document->template_file = null;
        $document->save();

        return redirect()->back();
    }

    public function deleteExample($id){
        $document = Document::find($id);
        if (!$document){
            return abort(404);
        }

        Storage::delete('documents/'.$document->example_file);
        $document->example_file = null;
        $document->save();

        return redirect()->back();
    }

    // CHECK DOCUMENTS

    public function checkView(){
        $document = UserDocument::where('status_id', 2)->first();
        return view('admin.documents.check', ['document' => $document]);
    }

    public function cancelDocument($id){
        $document = UserDocument::find($id);
        if (!$document){
            return abort(404);
        }

        $document->status_id = 4;
        $document->save();

        return to_route('admin.documents.check.view');
    }

    public function accessDocument($id){
        $document = UserDocument::find($id);
        if (!$document){
            return abort(404);
        }

        $document->status_id = 3;
        $document->save();

        return to_route('admin.documents.check.view');
    }
}
