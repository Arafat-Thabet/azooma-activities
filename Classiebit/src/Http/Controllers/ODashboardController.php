<?php

namespace Classiebit\Eventmie\Http\Controllers;
use Facades\Classiebit\Eventmie\Eventmie;


use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Classiebit\Eventmie\Models\Event;
use Classiebit\Eventmie\Models\User;
use Classiebit\Eventmie\Models\Booking;

use Classiebit\Eventmie\Charts\EventChart;
use Classiebit\Eventmie\Models\Notification;
use Yajra\Datatables\Datatables;

use Classiebit\Eventmie\Services\Dashboard;
use Classiebit\Eventmie\Http\Controllers\Voyager\VoyagerBaseController;
use Auth;
class ODashboardController extends VoyagerBaseController
{
    public function __construct()
    {
        $this->middleware(['organiser']);
        //dd(Auth::check());
        $this->dashboard_service = new Dashboard;
    }

    /**
     *  index page
     */
    public function index(Request $request)
    {
        // redirect if admin
        if(!checkUserRole('admin') && !checkUserRole('organiser'))
            return redirect(route('eventmie.welcome'));

        return $this->dashboard_service->index($request, userInfo()->id);
    }

    /**
     *  Event total by sales price
     */

    public function EventTotalBySalesPrice(Request $request)
    {
        $data = $this->dashboard_service->EventTotalBySalesPrice($request, userInfo()->id);
        
        echo json_encode($data);

    }

    /**
     *  get Event
     */

    public function getEvent(Request $request)
    {
        return $this->dashboard_service->getEvent($request, userInfo()->id);
    }
    
    
}    