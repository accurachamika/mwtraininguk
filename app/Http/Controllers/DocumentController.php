<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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


    public function truncate(): RedirectResponse
    {
        // Truncate the category table
        Document::truncate();

        // Redirect to the category page with a success message
        return redirect()->route('manage')->with('success', 'All documents have been deleted!');
    }
}
