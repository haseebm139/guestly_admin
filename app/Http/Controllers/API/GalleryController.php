<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LikePost;
use App\Models\CommentPost;
use App\Models\Gallery;
use App\Models\User;
use Carbon\Carbon;
use Str;
use DB;
use Validator;
use App\Http\Controllers\Api\BaseController as BaseController;
class GalleryController extends BaseController
{

    public function uploadGallery(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'file' => 'required|file',
                'file_type' => 'required',
                'caption'=> 'nullable'
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first());
            }
            if($request->hasFile('file'))
            {
                $img = time().$request->file('file')->getClientOriginalName();
                $file_path = "documents/gallery/".$img;
                $request->file->move(public_path("documents/gallery/"), $img);
                $input['file_path'] = $file_path;
            }
            $input['file_type'] = $request->file_type??null;
            $input['caption'] = $request->caption??null;
            $input['user_id'] = auth()->id()??null;
            Gallery::create($input);
            return $this->sendResponse($data = [],"File Upload Successfully");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }

    public function postLike(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'gallery_id' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first());
            }
            $my_id = auth()->id();
            $is_post = LikePost::where([
                'user_id'=>$my_id,
                'gallery_id'=>$request->gallery_id,
            ])->first();
            if (!isset($is_post)) {
                LikePost::create([
                    'user_id'=>$my_id,
                    'gallery_id'=>$request->gallery_id,
                ]);
                return $this->sendResponse($data = [],"Like");
            }else{
                $is_post->delete();
                return $this->sendResponse($data = [],"Un Like");
            }

        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }

    public function postComment(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'gallery_id' => 'required',
                'comment' => 'required',

            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first());
            }
            $my_id = auth()->id();
            LikePost::create([
                'user_id'=>$my_id,
                'gallery_id'=>$request->gallery_id,
                'comment'=>$request->comment,
            ]);
            return $this->sendResponse($data = [],"Comment Send Successfully");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }



    public function getUserImages(Request $request){
        $user_id = auth()->id();
        if(isset($request->id)){
            $user_id =$request->id;
        }
        try {
            $data = Gallery::where('user_id',$user_id)
            ->with('latest_comment')
            ->withCount(['likes','comments'])
            ->where('file_type', 'image')
            ->skip(7)
            ->take(20)
            ->orderBy('created_at', 'DESC')
            ->paginate(18);
            $this->isUserLike($data);
            return $this->sendResponse($data,"Images");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }

    public function getUserVideo(Request $request){
        try {
            $user_id = auth()->id();
            if(isset($request->id)){
                $user_id =$request->id;
            }
            $data = Gallery::where('user_id',$user_id)
            ->with('latest_comment')
            ->withCount(['likes','comments'])
            ->where('file_type', 'video')
            ->skip(7)
            ->take(20)
            ->orderBy('created_at', 'DESC')
            ->paginate(18);
            $this->isUserLike($data);

            return $this->sendResponse($data,"Images");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }

    public function postComments(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'post_id' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first());
            }

            $data = CommentPost::where('gallery_id',$request->post_id)

            ->orderBy('created_at', 'DESC')
            ->paginate(18);

            return $this->sendResponse($data,"Comments");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }

    public function isUserLike($data){

        $user_id = auth()->id();
        if (isset($data[0])) {
            # code...
            foreach ($data as $key => $value) {
                $liked = LikePost::where('user_id',$user_id)->where('gallery_id',$value->id)->first();
                if (isset($liked)) {

                    $data[$key]['isUserLike'] = true;
                }else{
                    $data[$key]['isUserLike'] = false;
                }
            }
        }
        return $data;
    }
}
