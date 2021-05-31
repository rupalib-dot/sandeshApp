<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Template;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        $templates = Template::select('*') 
        ->where('deleted_at', NULL)
        ->orderBy('id','desc')
        ->get();
        return view('admin.template.index', compact('templates','request'));
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
        $request->validate([
            'message'         => "required|min:4|max:250", 
        ]); 

        if(isset($request['id']) && $request['id'] != ""){
            $template = Template::where('id',$request['id'])->update([
                'message'         => $request['message'], 
                'updated_at'  => date('Y-m-d H:i:s'), 
            ]);
        }else{
            $template = Template::create([
                'message'         => $request['message'], 
                'block_status'  => config('constant.STATUS.UNBLOCK'), 
            ]);
        }

        if(!empty($template)){ 
            if(isset($request['id']) && $request['id'] != ""){
                return redirect()->route('admin.template.index')->with('Success','Template has been updated successfully');
            }else{
                return redirect()->route('admin.template.index')->with('Success','Template has been added successfully');
            }
        }else{
            return redirect()->route('admin.template.index')->with('Failed','Something went wrong'); 
        }
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
    public function destroy($id)
    {
        $template = Template::where('id',$id)->update([
            'deleted_at'      => date('Y-m-d H:i:s'),
        ]);

        if(!empty($template)){  
            return redirect()->route('admin.template.index')->with('Success','Template has been deleted successfully'); 
        }else{
            return redirect()->route('admin.template.index')->with('Failed','Something went wrong'); 
        }
    
    }

    public function changeStatus($id, $status)
    {

        $template = Template::where('id',$id)->update([
            'block_status'      => $status,
            'updated_at'      => date('Y-m-d H:i:s'),
        ]);

        if(!empty($template)){  
            return redirect()->route('admin.template.index')->with('Success','Template has been '.array_search($status,config('constant.STATUS')).'ed successfully'); 
        }else{
            return redirect()->route('admin.template.index')->with('Failed','Something went wrong'); 
        } 
    }
}
