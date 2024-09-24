<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentOld;
use App\Models\User;
use App\Models\UserOld;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class DataMigrationController extends Controller
{
    public function migrateUsers()  {

        ini_set('max_execution_time', 1000);
       
        $userOld = UserOld::select('std_id', 'password','reg_date')->get();

        foreach ($userOld as $user) {

            if($user->std_id === null || $user->std_id === ''){
                continue;
            }

            $exist = User::where('user_name' , $user->std_id)->first();
           
            if(!$exist){
                $u = User::create([
                    'user_name' => $user->std_id,
                    'password' => Hash::make($user->password),
                    'created_at' => $user->reg_date === 0 || $user->reg_date === null ? Carbon::now() : $user->reg_date ,
                ]);
                event(new Registered($u));
            }
        }

        return redirect()->route('userlist')->with('success', 'Users are Successfully migrated');


    }

    public function truncateUsers()  {
        User::truncate();
        Artisan::call('db:seed', ['--class' => 'UsersTableSeeder']);

        return redirect()->route('userlist')->with('success', 'Users are Successfully deleted');
    }

    # User Count 2298
    # Old Doc Count 51848 
    # New Doc Count after doc migration 51848 

    public function migrateDocs() {
        ini_set('max_execution_time', 5000);
    
        // Retrieve all old documents
        $old_docs = DocumentOld::all(); // Assume this is 51848 records
    
        foreach ($old_docs as $doc) {
            // Check if the document already exists in the new table
            $existingDoc = Document::where('file_name', $doc->file_name)
                                   ->where('doc_type', $doc->doc_type)
                                   ->where('std_id', $doc->student_id)
                                   ->first();
    
            if ($existingDoc) {
                // If the document already exists, skip it
                continue;
            }
    
            // Migrate the document to the new table if it doesn't exist
            Document::create([
                'file_name' => $doc->file_name,
                'doc_type' => $doc->doc_type,
                'std_id' => $doc->student_id,
                'std_name' => $doc->std_name ?? 'Unknown', // Fallback if null
                'last_updated' => $doc->last_updated ?? now(),
                'uploaded_by' => $doc->uploaded_by === 6 ? 'mikewoo' : 'admin',
                'mime' => $doc->mime ?? 'application/octet-stream', // Default MIME if null
                'desc' => $doc->desc ?? 'No description available'
            ]);
        }

            //     foreach ($users as $user ) {
            //         $old_doc = DocumentOld::where('student_id' , $user->user_name)->get();

            //         foreach ($old_doc as $doc) {
            //             Document::create([
            //                 'file_name' => $doc->file_name,
            //                 'doc_type' => $doc->doc_type,
            //                 'std_id' => $doc->student_id,
            //                 'std_name' => $doc->std_name,
            //                 'last_updated' => $doc->last_updated,
            //                 'uploaded_by' => $doc->uploaded_by === 6 ? 'mikewooi' : 'admin',
            //                 'mime' => $doc->mime,
            //                 'desc' => $doc->desc
            //             ]);
            //         }
            //     }
    
        return redirect()->route('userlist')->with('success', 'Data successfully migrated');
    }    

    public function migrateUsersDocs() {
        // Extend script execution time to handle large data
        ini_set('max_execution_time', 5000);
    
        try {
            // Process users in chunks to avoid memory overload
            User::chunk(100, function ($users) {
                foreach ($users as $user) {
                    // Retrieve old documents for the current user
                    $old_docs = DocumentOld::where('student_id', $user->user_name)->get();
                    
                    if ($old_docs->isEmpty()) {
                        continue; // Skip if no old documents found
                    }
    
                    foreach ($old_docs as $doc) {
                        // Ensure required fields are not null
                        if (!$doc->file_name || !$doc->doc_type || !$doc->student_id) {
                            // Log skipped entry if important fields are missing
                            Log::warning("Skipped document with missing fields for student_id: {$doc->student_id}");
                            continue; // Skip this document if key fields are missing
                        }
    
                        // Check if the same document already exists in the Document table
                        $existingDoc = Document::where('file_name', $doc->file_name)
                                               ->where('doc_type', $doc->doc_type)
                                               ->where('std_id', $doc->student_id)
                                               ->first();
    
                        if ($existingDoc) {
                            // Skip the document if it already exists
                            Log::info("Skipped existing document for student_id: {$doc->student_id}, file_name: {$doc->file_name}");
                            continue;
                        }
    
                        // Migrate the document to the new table if it doesn't exist
                        Document::create([
                            'file_name' => $doc->file_name,
                            'doc_type' => $doc->doc_type,
                            'std_id' => $doc->student_id,
                            'std_name' => $doc->std_name ?? 'Unknown', // Fallback if null
                            'last_updated' => $doc->last_updated ?? now(),
                            'uploaded_by' => $doc->uploaded_by === 6 ? 'mikewoo' : 'admin',
                            'mime' => $doc->mime ?? 'application/octet-stream', // Default MIME if null
                            'desc' => $doc->desc ?? 'No description available'
                        ]);
                    }
                }
            });
    
            return redirect()->route('userlist')->with('success', 'Data successfully migrated');
        } catch (\Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Document migration failed: ' . $e->getMessage());
            return redirect()->route('userlist')->with('error', 'Data migration failed. Check logs for details.');
        }
    }
    
    

}
