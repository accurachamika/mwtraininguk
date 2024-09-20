<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class DocumentController extends Controller
{
    public function docPost(Request $request)  {

        #validate Form data
        $request->validate([
            'std_id' => 'required',
            'std_name' => 'required',
            'doc_cat' => 'required',
            'document' => 'required|file',
            'doc_desc' => 'nullable'
            ]);


        #Student Details 
        $std_id = $request->std_id;
        $std_name = str_replace(' ' , '_', $request->std_name);
        $doc_cat = $request->doc_cat;
        $doc_desc = $request->doc_desc ? $request->doc_desc : null;


        #File Details
        $document = $request->file('document');
        $mimeType = $document->getMimeType();
        $fileName = $document->getClientOriginalName();
        $ext = $document->getClientOriginalExtension();
        
        #Generate the new file name
        $timestamp = time();
        $newFileName = $timestamp .'~'.$std_id.'_'.$std_name.'_'.$doc_cat.'.'.$ext ;
    
        # Define the directory structure
        $directory = "resources/$std_id/$doc_cat";
        
        # Create the directory if it doesn't exist
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true); // 0777 permissions, true for recursive creation
        }

        # Database
        $documentCreated = Document::create([
            'file_name' => $newFileName,
            'std_id' => $std_id,
            'std_name' => $std_name,
            'doc_type' => $doc_cat,
            'last_updated' => Carbon::now(),
            'doc_category' => $doc_cat,
            'uploaded_by' => $request->uploaded_by,
            'mime' => $mimeType,
            'desc' => $doc_desc
        ]);

        # Store the file in the defined directory
        $document->move(public_path($directory), $newFileName);

        if($documentCreated){
            return redirect()->route('manage')->with('success', 'File Uploaded successfully!');
        }else{
            return redirect()->route('manage')->with('error', 'Failed to Upload File');
        }
    }

    public function manageView($id)  {
        $document = Document::find($id);
        
        return view('pages.manage.view', ['doc' => $document]);
    }


    public function manageUpdate($id)  {
        $document = Document::find($id);
        $doc_type = Category::all();

        
        return view('pages.manage.update', ['doc' => $document , 'doc_type' => $doc_type]);
    }

    public function updatePost(Request $request )  {

    # Find the document record in the database
    $documentRecord = Document::findOrFail($request->doc_id);

    # Validate Form data
    $request->validate([
        'std_id' => 'required',
        'std_name' => 'required',
        'doc_cat' => 'required',
        'document' => 'nullable|file',  // 'nullable' here allows the document to be null
        'doc_desc' => 'nullable'
    ]);

    # Student Details
    $std_id = $request->std_id;
    $std_name = str_replace(' ', '_', $request->std_name);
    $doc_cat = $request->doc_cat;
    $doc_desc = $request->doc_desc ? $request->doc_desc : null;

    # Check if a new document is uploaded
    if ($request->hasFile('document')) {
        # File Details
        $document = $request->file('document');
        $mimeType = $document->getMimeType();
        $ext = $document->getClientOriginalExtension();

        # Generate the new file name
        $timestamp = time();
        $newFileName = $timestamp .'~'.$std_id.'_'.$std_name.'_'.$doc_cat.'.'.$ext ;

        # Define the directory structure
        $directory = "resources/$std_id/$doc_cat";

        # Create the directory if it doesn't exist
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        # Remove the old file if it exists
        $oldFilePath = public_path($directory.'/'.$documentRecord->file_name);
        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        # Store the new file in the defined directory
        $document->move(public_path($directory), $newFileName);

        # Update the document record with new file information
        $documentRecord->file_name = $newFileName;
        $documentRecord->mime = $mimeType;
        }

        # Update other fields in the database
        $documentRecord->std_id = $std_id;
        $documentRecord->std_name = $std_name;
        $documentRecord->doc_type = $doc_cat;
        $documentRecord->last_updated = Carbon::now();
        $documentRecord->desc = $doc_desc;
        $documentRecord->uploaded_by = $request->uploaded_by;
        
        // dd($documentRecord);
        # Save the updated record
        if($documentRecord->save()){
            return redirect()->route('manage')->with('success', 'Document updated successfully!');
        } else {
            return redirect()->route('manage')->with('error', 'Failed to update Document');
        }
            
        }

    public function manageDelete($id)  {
        $document = Document::find($id);
        $document_path =  "resources/$document->std_id/$document->doc_type/$document->file_name";
        
        if($document->delete()){
            if(file_exists($document_path)){
                unlink($document_path);
            }
            return redirect()->route('manage')->with('success', 'Document Deleted successfully!');
        } else {
            return redirect()->route('manage')->with('error', 'Failed to delete Document');
        }
    }


    public function truncate(): RedirectResponse
    {
        // Truncate the category table
        Document::truncate();

        // Redirect to the category page with a success message
        return redirect()->route('manage')->with('success', 'All documents have been deleted!');
    }

    public function truncateRes(): RedirectResponse
    {
        // Truncate the category table
        Document::truncate();
        $document_path =  "resources";

        if(file_exists($document_path)){
            File::deleteDirectory(public_path($document_path));
        }

        // Redirect to the category page with a success message
        return redirect()->route('manage')->with('success', 'All documents have been deleted!');
    }


    public function std_Filter() {
        
        $std_id = Auth::user()->user_name;

        $documents = Document::where('std_id' , $std_id)->get();
        
        return view('pages.std.manage' , ['documents' => $documents]);
    }

    public function filter($std_id_filter) {
        if($std_id_filter){
            $std_id = $std_id_filter;
        }else{
            $std_id = Auth::user()->user_name;
        }
        
        $documents = Document::where('std_id' , $std_id)->get();
        
        return view('pages.manage' , ['documents' => $documents]);
    }

    public function manageDownload($id)  {
        $document = Document::findOrFail($id);

        // Define the file path
        $filePath = public_path("resources/{$document->std_id}/{$document->doc_type}/{$document->file_name}");

        if (file_exists($filePath)) {
            return response()->download($filePath, $document->file_name);
        } else {
            return redirect()->route('manage')->with('error', 'File not found!');
        }
    }

    public function manageDocView($doc_id) {
        $documents = Document::findOrFail($doc_id);
        $filePath = public_path("resources/{$documents->std_id}/{$documents->doc_type}/{$documents->file_name}");

        if (file_exists($filePath)) {
            // If it's a PDF, render it in a view
            return view('pages.manage.document', ['fileUrl' => asset("resources/{$documents->std_id}/{$documents->doc_type}/{$documents->file_name}")]);
        } else {
            return redirect()->back()->with('error', 'File not found!');
        }
    }

    
}
