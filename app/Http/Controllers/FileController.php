<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index()
   {
       return view('files.fileUpload');
   }

//a mértékegység kb-ban értendő:
public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:txt,pdf,xlx,csv|max:2048',
        ]);
   	//ha eredeti nevét megtartanád, a jobb oldalon legyen: $request->file->getClientOriginalName();
        $fileName = $request->file->getClientOriginalName();  


        $request->file->move(public_path('uploads'), $fileName);


        /*  
            Write Code Here for
            Store $fileName name in DATABASE from HERE
        */
   
        return back()
            ->with('success','You have successfully upload file.')
            ->with('file', $fileName);


    }

}
