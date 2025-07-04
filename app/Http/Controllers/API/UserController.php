<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Interest;
use App\Models\FriendRequestList;
use App\Models\FriendList;

use Carbon\Carbon;
use Str;
use DB;
use Validator;
use App\Http\Controllers\API\BaseController as BaseController;
class UserController extends BaseController
{
    public function getProfile(Request $request,User $user){
        try {

            $user_id = auth()->id();
            if(isset($request->id)){
                $user_id =$request->id;
            }
            $data = $user->with(['interests'])->find($user_id);
            $data['isFriend'] = $this->isFriend($data);
            return $this->sendResponse($data,"My Profile");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }

    public function isFriend($data){
        $user_id = auth()->id();
        $friend_id = $data->id;
        $is_friend = FriendList::where([
            "user_id"=>$user_id,
            "friend_id"=>$friend_id,
        ])->first();
        if (isset($is_friend)) {
            $data['isFriend'] = true;
        }else{
            $data['isFriend'] = false;
        }
        return  $data;
    }
    public function updateProfile(Request $request,User $user){
        try {
            $user_id = auth()->id();
            $user = $user->find($user_id);
            $item = null;
            $data = $user->find($user_id);
            if ($request->name != $user->name) {
                $item['name'] = $request->name ;
            }
            if ($request->date_of_birth != $user->date_of_birth) {
                $item['date_of_birth'] = Carbon::parse($request->date_of_birth);
            }
            if ($request->gender != $user->gender) {
                $item['gender'] = stringLowerCase($request->gender);
            }
            if ($request->city != $user->city) {
                $item['city'] = stringLowerCase($request->city);
            }
            if ($request->country != $user->country) {
                $item['country'] = stringLowerCase($request->country);
            }
            if ($request->job != $user->job) {
                $item['job'] = stringLowerCase($request->job);
            }
            if ($request->company != $user->company) {
                $item['company'] = stringLowerCase($request->company);
            }
            if ($request->college != $user->college) {
                $item['college'] = $request->college;
            }
            $user->interests()->delete();
            if($request->interests){
                $interest_list = stringIntoArray($request->interests);

                foreach ($interest_list as $key => $value) {
                    $userInterest = Interest::where(['name'=>$value,'user_id'=>$user_id])->first();
                    if (!isset($userInterest)) {
                        Interest::create([
                            'name'=>$value,
                            'user_id'=>$user_id
                        ]);
                    }
                }
            }



            if ($request->bio != $user->bio) {
                $item['bio'] = $request->bio;
            }
            if($request->hasFile('avatar'))
            {
                $img = time().$request->file('avatar')->getClientOriginalName();
                $file_path = "documents/gallery/".$img;
                $request->avatar->move(public_path("documents/gallery/"), $img);
                $input['avatar'] = $file_path;
            }

            $user->update($item);
            $data = $user->with('interests')->find($user_id);

            return $this->sendResponse($data,"My Profile");

        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }


    public function listSubscription(){
        try {
            //code...
            $data = Subscription::select('id','time_duration','offer_name','offer_title','price')->where('status',1)->get();
            if (!isset($data[0])) {
                return $this->sendError("Empty List");
            }
            return $this->sendResponse($data,"Subscription List");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }

    public function friendsList(){

        try {
            //code...
            $user_id = auth()->id();
            $data = FriendList::with(['friend'])->where('user_id',$user_id)->select('user_id','friend_id','id')->get();
            if (!isset($data[0])) {
                return $this->sendError("Empty List");
            }
            return $this->sendResponse($data,"Friends List");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }
    // Begin::Request Process
    public function sendFriendRequest(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first());
            }
            $senderId = auth()->id();
            $receiverId = $request->user_id;
            if ($senderId == $receiverId) {
                return $this->sendError("Both User Are Same");
            }
            $checkRequest = FriendRequestList::where(function ($query) use ($senderId, $receiverId) {
                $query->where(function ($q) use ($senderId, $receiverId) {
                    $q->where('sender_id', $senderId)
                    ->where('receive_id', $receiverId);
                })->orWhere(function ($q) use ($senderId, $receiverId) {
                    $q->where('sender_id', $receiverId)
                    ->where('receive_id', $senderId);
                });
            })->first();


            if (!isset($check_request)) {

                FriendRequestList::create([
                    'sender_id'=>$senderId,
                    'receive_id'=>$receiverId,
                ]);
                return $this->sendResponse($data= [],"Send Friend Request Successfully");
            }
            return $this->sendResponse($data= [],"Already Exist");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }
    public function receiveFriendRequest(Request $request){
        try {
            $receiveId = auth()->id();
            $data = FriendRequestList::where([
                'receive_id'=>$receiveId,
                'status'=>0
            ])->paginate(20);

            return $this->sendResponse($data,"Friend Request List");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }
    public function acceptFriendRequest(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|numeric',

            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first());
            }

            $id = $request->id;
            $checkRequest = FriendRequestList::where('status',0)->where('id',$id)->first();
            if (!isset($checkRequest)) {
                return $this->sendError("Request Not Found");
            }
            $userId = $checkRequest->receive_id;
            $friendId = $checkRequest->sender_id;
            FriendList::create([
                'user_id'=>$userId,
                'friend_id'=>$friendId,
            ]);
            FriendList::create([
                'user_id'=>$friendId,
                'friend_id'=>$userId,
            ]);
            $checkRequest->update([
                'status'=>1
            ]);
            return $this->sendResponse($data= [],"Accept Friend Request");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }
    public function rejectFriendRequest(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|numeric',

            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first());
            }

            $id = $request->id;
            $checkRequest = FriendRequestList::where('status',0)->where('id',$id)->first();
            if (!isset($checkRequest)) {
                return $this->sendError("Request Not Found");
            }
            $userId = $checkRequest->receive_id;
            $friendId = $checkRequest->sender_id;
            FriendList::where([
                'user_id'=>$userId,
                'friend_id'=>$friendId,
            ])->delete();
            FriendList::where([
                'user_id'=>$friendId,
                'friend_id'=>$userId,
            ])->delete();
            $checkRequest->delete();
            return $this->sendResponse($data= [],"Reject Friend Request");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }

    public function userSearch(Request $request){
        try {

            $validator = Validator::make($request->all(), [
                'keyword' => 'required',

            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first());
            }
            $my_id = auth()->id();
            $users = User:: where('role_id','user')
            ->where('id','!=',$my_id)
            ->orWhere('name', 'like', "%$keyword%")
            ->orWhere('email', 'like', "%$keyword%")
            ->orWhere('city', 'like', "%$keyword%")
            ->orWhere('country', 'like', "%$keyword%")
            ->orWhere('email', 'like', "%$keyword%")
            ->orWhere('job', 'like', "%$keyword%")
            ->orWhere('gender', 'like', "%$keyword%")
            ->orWhere('company', 'like', "%$keyword%")
            ->orWhere('college', 'like', "%$keyword%")
            ->orWhere('bio', 'like', "%$keyword%")
            ->paginate(10);
            return $this->sendResponse($data= [],"Reject Friend Request");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }
    // End::Request Process
    public function newMatchUser(){
        try {
            $user_id = auth()->id();
            $users = User::Query();
            $data = $this->newMatch($users);

            return $this->sendResponse($data,"New Match User data");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }

    public function nearUser(){
        try {
            $user_id = auth()->id();
            $users = User::Query();
            $data = $this->nearYou($users);
            return $this->sendResponse($data,"Near Users data");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }
    public function recentPartnerUser(){
        try {
            $user_id = auth()->id();
            $users = User::Query();
            $data = $this->recentPartners();
            return $this->sendResponse($data,"Recent Partners data");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }

    public function homeScreenApi(){
        try {
            $user_id = auth()->id();
            $users = User::Query();
            $data['new_match'] = $this->newMatch($users);
            $data['nearYou'] = $this->nearYou($users);
            $data['recentPartners'] = $this->recentPartners();
            return $this->sendResponse($data,"Home data");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }
    public function newMatch($users){
        $user = auth()->user();
        $friends = friendsIds();
        $user_id = $user->id ;
        $data = $users->where('id','!=',$user_id)
        ->where('user_type','user')
        ->whereNotIn('id',$friends)
        ->paginate(20);
        return $data;
    }

    public function nearYou($users){
        $user = auth()->user();

        $latitude = $user->latitude;
        $longitude = $user->longitude;

        $friends = friendsIds();
        $user_id = $user->id ;
        $data = $users->where('id','!=',$user_id)
        ->where('user_type','user')
        ->whereNotIn('id',$friends)
        ->select(DB::raw(
            "*, (6371 * acos(cos(radians($latitude))
                * cos(radians(latitude))
                * cos(radians(longitude) - radians($longitude))
                + sin(radians($latitude))
                * sin(radians(latitude)))) AS distance"
        ))
        ->orderBy('distance', 'asc')
        ->paginate(20);
        return $data;

    }
    public function recentPartners(){
        $user = auth()->user();
        $friends = friendsIds();
        $user_id = $user->id ;
        $data = User::whereIn('id',$friends)->paginate(20);
        return $data;
    }


}
