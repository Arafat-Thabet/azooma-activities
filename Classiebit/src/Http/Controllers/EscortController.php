<?php

namespace Classiebit\Eventmie\Http\Controllers;

use App\Http\Controllers\Controller; 
use Facades\Classiebit\Eventmie\Eventmie;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use Auth;
use Classiebit\Eventmie\Models\Booking;
use Classiebit\Eventmie\Models\Booking_escort;
use Classiebit\Eventmie\Models\Escort;
use Symfony\Component\HttpFoundation\Response;

class EscortController extends Controller
{
public function add_book_escort($id)
    {
        $booking=Booking::findOrFail($id);
        $escorts=Escort::all();
        $booking_escorts=Booking_escort::select(["*"])->where("booking_id","=",$id)->join('escorts', 'escorts.id', '=', 'booking_escorts.escort_id')->get();
        $ids=[];
        foreach($booking_escorts as $e)
        $ids[]=$e->escort_id;
        //return  ($booking->event_title);
        return Eventmie::view('eventmie::escort.add', compact('booking','escorts','booking_escorts','ids',"id"));

    }
    public function save(Request $request){
      //  dd($request);
      if(empty($request->escort)){
      return redirect()
      ->route("voyager.bookings.index")
      ->with([
          'message'    => __("please selected escorts"),
          'alert-type' => 'error',
      ]);
    }
        $booking=Booking::findOrFail($request->booking_id);
        foreach($request->escort as $id){
        $data []= 
            ['booking_id'=>$request->booking_id, 'escort_id'=> $id,'customer_id'=>($booking->customer_id??0)];
    }
    if($data)
    Booking_escort::where('booking_id','=',$request->booking_id)->delete();
    Booking_escort::insert($data);
    return redirect()
    ->route("voyager.bookings.index")
    ->with([
        'message'    => __("Escorts updated"),
        'alert-type' => 'success',
    ]);
    }
}