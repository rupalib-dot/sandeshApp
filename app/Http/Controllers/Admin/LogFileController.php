<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\File;
use Illuminate\Http\Request; 

class LogFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $path 		= public_path('/assets/logfiles/'); 
    	$files 		= chdir($path);  
		array_multisort(array_map('filemtime', ($files = glob("*.*"))), SORT_DESC, $files);
		$title 	= "Log Files"; 
        return view('admin.logfiles.index',compact('title','files')); 
    }

 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$name)
    {
        $imgToDel = public_path("/assets/logfiles/" . $name);
		if (file_exists($imgToDel)) {
			unlink($imgToDel);
		}
		return redirect()->route('admin.logfiles.index')->with('Success', 'File Deleted Successfully...');
    }
}
