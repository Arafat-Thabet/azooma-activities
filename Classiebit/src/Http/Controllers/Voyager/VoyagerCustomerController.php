<?php

namespace Classiebit\Eventmie\Http\Controllers\Voyager;

use Facades\Classiebit\Eventmie\Eventmie;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataDeleted;
use TCG\Voyager\Events\BreadDataRestored;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Events\BreadImagesDeleted;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\Traits\BreadRelationshipParser;
use Illuminate\Http\RedirectResponse;

use TCG\Voyager\Http\Controllers\VoyagerUserController as BaseVoyagerUserController;
use Auth;
use Classiebit\Eventmie\Models\User;

use Illuminate\Support\Carbon;
use Classiebit\Eventmie\Notifications\MailNotification;
use Classiebit\Eventmie\Http\Controllers\Voyager\BaseController as BaseController;

class VoyagerCustomerController extends BaseVoyagerUserController
{
    public function index(Request $request)
    {
        return (new  BaseController())->custom_index($request,['sortable'=>false]);
    }

    public function show(Request $request, $id)
    {
        return (new  BaseController())->show($request, $id);
    }
    public function create(Request $request)

    {
        return (new  BaseController())->create($request);
    }
    public function edit(Request $request, $id)
    {
        return (new  BaseController())->edit($request, $id);
    }
}
