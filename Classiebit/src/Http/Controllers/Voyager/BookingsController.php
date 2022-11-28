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
use Auth;

use Classiebit\Eventmie\Models\Commission;

class BookingsController extends BaseController
{
    use BreadRelationshipParser;

    public function __construct()
    {
        // disable modification functions that are not managed from admin panel
        $route_name     = "voyager.bookings";
        $enable_routes = [
            "$route_name.index", 
            "$route_name.show", 
            "$route_name.edit", 
            "$route_name.update", 
            "$route_name.destroy",
        ];
        if(! in_array(\Route::current()->getName(), $enable_routes))
        {
            return redirect()->route('voyager.bookings.index')->send();
        }
        // ---------------------------------------------------------------------

        $this->commission   = new Commission;  
    }

    //***************************************
    //               ____
    //              |  _ \
    //              | |_) |
    //              |  _ <
    //              | |_) |
    //              |____/
    //
    //      Browse our Data Type (B)READ
    //
    //****************************************
    
    public function index(Request $request,$actions = [])
    {
        return $this->custom_index($request, [
            'addable' => false,
            'editable' => false,
            'deleteable' => false,
            'sortable' => false,
        ]);
    }

    // POST BR(E)AD
    public function update(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Compatibility with Model binding.
        $id = $id instanceof \Illuminate\Database\Eloquent\Model ? $id->{$id->getKeyName()} : $id;

        $model = app($dataType->model_name);
        if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope'.ucfirst($dataType->scope))) {
            $model = $model->{$dataType->scope}();
        }
        if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
            $data = $model->withTrashed()->findOrFail($id);
        } else {
            $data = $model->findOrFail($id);
        }

        // Check permission
        $this->authorize('edit', $data);

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->editRows, $dataType->name, $id)->validate();
        $this->insertUpdateData($request, $slug, $dataType->editRows, $data);



        // extra data update ========================================================================
        
        $params = [
            'booking_id'       => $id,
            'organiser_id'     => $data->organiser_id,
            'status'           => $request->status == "on" ? 1 : 0,
        ];
        
        // edit commision table status when change booking table status change by organiser 
        $edit_commission  = $this->commission->edit_commission($params);    
        
        if(empty($edit_commission))
            return error('Commission not found!', Response::HTTP_BAD_REQUEST );
        // extra data update ========================================================================

        event(new BreadDataUpdated($dataType, $data));

        if (auth()->user()->can('browse', app($dataType->model_name))) {
            $redirect = redirect()->route("voyager.{$dataType->slug}.index");
        } else {
            $redirect = redirect()->back();
        }

        return $redirect->with([
            'message'    => __('voyager::generic.successfully_updated')." {$dataType->getTranslatedAttribute('display_name_singular')}",
            'alert-type' => 'success',
        ]);
    }

    
    
}
