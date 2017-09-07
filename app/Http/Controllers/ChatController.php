<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vinkla\Pusher\Facades\Pusher;
use App\Http\Requests;
use Validator;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        return \View::make('chat');
    }

    public function postPusherauth(Request $request){
		$channel = $request->input('channel_name');
		$socket_id = $request->input('socket_id');
		$data = Pusher::socket_auth($channel, $socket_id);
		header('Content-Type: application/json');
		echo $data;
    }
	
	/**
	 * Trigger event menggunakan HTTP
	 */
    public function postPushertrigger(Request $request){
		
		$channel = $request->input('channel_name');
		$event = $request->input('event_name');
		$data = $request->input('message');
		
		//optional
		$socket_id = $request->input('socket_id');
		
        $validate = Validator::make($request->all(), [
            'channel_name' => 'required',
			'event_name' => 'required',
			'message' => 'required'
        ]);
		
		if ($validate->fails()) {
            return \Response::json([
                'pusher' => array(
                    'status' => array('code' => 400, 'message' => 'error'),
                    'data' => array('field_errors' => $validate->errors())
                )
            ], 400);
        }
		
		$trigger = Pusher::trigger(
					$channel,
                    $event, $data, $socket_id);
		
		$msdmfm = array( 'message'=> $data);
		
		return response()->json($msdmfm);
    }
	
}
