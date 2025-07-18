<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FAQ;
use Validator;
class FAQController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data =FAQ::all();
        return view('pages.apps.admin.faq.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'answer' => 'required',
            'lang' =>'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->with(['type'=>'error','message'=>$validator->errors()->first()]);

        }

        try {

            FAQ::create([
                'question' => $request->question,
                'answer' => $request->answer,
                'lang' => $request->lang,
            ]);

            return redirect()->back()->with(['type' => 'success', 'message' => 'Data stored successfully']);
        } catch (\Throwable $e) {
            return redirect()->back()->with(['type' => 'error', 'message' => 'Something went wrong']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = FAQ::find($id);
        if (!isset($data)) {
            return redirect()->route('app-management.faq.index')->with(['message'=>'Data Not Found','type'=>'error']);
        }
        return view('pages.apps.admin.faq.edit', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = FAQ::find($id);
        if (!isset($data)) {
            return redirect()->route('app-management.faq.index')->with(['message'=>'Data Not Found','type'=>'error']);
        }
        return view('pages.apps.admin.faq.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = FAQ::find($id);
                if (!isset($data)) {
                    return redirect()->route('app-management.faq.index')->with(['message'=>'Data Not Found','type'=>'error']);
                }
            if ($request->question) {
                $input['question']  = $request->question;
            }
            if ($request->answer) {
                $input['answer']  = $request->answer;
            }
            if ($request->lang) {
                $input['lang']  = $request->lang;

            }
            $data->update($input);

            return redirect()
            ->route('app-management.faq.index')
            ->with(['message'=>'Updated Successfully','type'=>'success']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message'=>'Something went wrong','type'=>'error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = FAQ::find($id);
            if (!isset($data)) {
                return redirect()->route('app-management.faq.index')->with(['message'=>'Data Not Found','type'=>'error']);
            }
            $data->delete();
            return redirect()
                ->route('app-management.faq.index')
                ->with(['message'=>'Deleted Successfully','type'=>'success']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message'=>'Something went wrong','type'=>'error']);
        }
    }
    public function change_status(Request $request)
    {
        try {
            //code...
            $statusChange = FAQ::where('id',$request->id)->update(['status'=>$request->status]);
            if($statusChange)
            {
                return array('message'=>'Status has been changed successfully','type'=>'success');
            }else{
                return array('message'=>'Status has not changed please try again','type'=>'error');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message'=>'Something went wrong','type'=>'error']);
        }

    }
}
