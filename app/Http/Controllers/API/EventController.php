<?php

namespace App\Http\Controllers\API;

use App\Models\Event;
use App\Models\UserEventList;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;
class EventController extends BaseController
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->id();
        $today = Carbon::today();  
        $invited_ids = $this->invitedIds();
        $events = Event::
        whereNotIn('id',$invited_ids)
        ->where('user_id', '!=', $user_id)
        ->where('date', '>=', $today->format('Y-m-d'))
        ->paginate(20);
        $data = $this->participates($events);
        return $this->sendResponse($data,"Events");
        try {
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }

    public function index1()
    {
        try {
            $user_id = auth()->id();
            $today = Carbon::today();  
            $events = Event::where('user_id',$user_id)
            ->where('date', '>=', $today->format('Y-m-d'))
            ->paginate(20); 
            $data = $this->participates($events);
            return $this->sendResponse($data,"Events");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'address' => 'required|string',
                'description' => 'required|string',
                'date' => 'required|date',
                'start_time' => 'required|date_format:H:i:s',
                'end_time' => 'required|date_format:H:i:s',
                'longitude' => 'required|numeric|between:-180,180',
                'latitude' => 'required|numeric|between:-90,90', 
            ]);
    
            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first());
            }
            $item = $request->all();
            $item['user_id'] = auth()->id();   
            $event = Event::create($item);
            return $this->sendResponse($data = [],"Events Add Successfully");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
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
        try {             
            $event = Event::where(['id'=>$id])->first();

            if (!$event) {
                return $this->sendError("Event not found"); 
            }

            return $this->sendResponse($event,"Event");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
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
        try{
            
            $event = Event::where(['id'=>$id,'user_id'=>auth()->id()])->first();
            if (!$event) {
                return $this->sendError("Event not found"); 
            }

            $validator = Validator::make($request->all(), [
                'name' => 'nullable|string|max:255',
                'address' => 'nullable|string',
                'description' => 'nullable|string',
                'date' => 'nullable|date',
                'start_time' => 'nullable|date_format:H:i:s',
                'end_time' => 'nullable|date_format:H:i:s',
                'longitude' => 'nullable|numeric|between:-180,180',
                'latitude' => 'nullable|numeric|between:-90,90',
                'status' => 'nullable|in:' . implode(',', array_keys(Event::$statuses)), // Validate against status options
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first());
            }
            $item = $request->all();
            $item['user_id'] = auth()->id(); 
            $event->update($item); // Update the event with validated data
            $event = Event::where(['id'=>$id,'user_id'=>auth()->id()])->first();
            return $this->sendResponse($event,"Event Update");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }

    public function destroy($id)
    {
        try {
            $event = Event::where(['id' => $id, 'user_id' => auth()->id()])->first();

            if (!$event) {
            return $this->sendError("Event not found");
            }

            $event->delete();

            return $this->sendResponse([], "Event Deleted Successfully");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }

    public function accept($id)
    {
        try {         
            $user_id = auth()->id();    
            $data = Event::where('user_id', '!=', $user_id) 
            ->where('id', '!=', $id)->first();

            if (!$event) {
                return $this->sendError("Event not found"); 
            }
            $check = UserEventList::where([
                'user_id'=>auth()->id(),
                'event_id'=>$event->id, 
            ])->first();
            if (isset($check)) {
                $check->update([
                    'type'=>'accept'
                ]);
            }else{
                UserEventList::create([
                    'user_id'=>auth()->id(),
                    'event_id'=>$event->id,
                    'type'=>'accept'
                ]);

            }
            return $this->sendResponse($data =[],"Accept Event Request");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }

    public function reject($id)
    {
        try {  
            $user_id = auth()->id();           
            $data = Event::where('user_id', '!=', $user_id) 
            ->where('id', '!=', $id)->first();
    
            if (!$event) {
                return $this->sendError("Event not found"); 
            }
            $check = UserEventList::where([
                'user_id'=>auth()->id(),
                'event_id'=>$event->id, 
            ])->first();
            if (isset($check)) {
                $check->update([
                    'type'=>'reject'
                ]);
            }else{
    
                UserEventList::create([
                    'user_id'=>auth()->id(),
                    'event_id'=>$event->id,
                    'type'=>'reject'
                ]);
            }
            return $this->sendResponse($data =[],"Reject Event Request");
        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }
    }

    public function invitedIds(){
        $data = UserEventList::where([
            'user_id'=>auth()->id(), 
        ])->pluck('event_id');
        return $data;
    }

    public function participates($data){
         
        $arr = $data->items(); // Get the items from the paginator

        foreach ($arr as $key => $value) {
            // Check if the audio is a favorite for the user
            $count = UserEventList::where([
                'event_id' => $value->id, 
            ])->count();

         
            $arr[$key]->participates = $count ;
        }

        // Replace the original data items with the modified items
        $data->setCollection(collect($arr));

        return $data;
    }

    


}
