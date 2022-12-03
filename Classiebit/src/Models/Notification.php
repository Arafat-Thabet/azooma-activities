<?php

namespace Classiebit\Eventmie\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

use Classiebit\Eventmie\Models\User;
use Classiebit\Eventmie\Models\Customer;
use Auth;

class Notification extends Model
{


    /**
     *  total notification only for admin
     */
    public function total_notifications()
    {

        $mode           = config('database.connections.mysql.strict');
        $user_type = 'customer';
        if (Auth::guard('admin')->check() && (Auth::guard('admin')->user()->hasRole('admin') or Auth::guard('admin')->user()->hasRole('organiser'))) {
            $user_id        = Auth::guard('admin')->user()->id;
            $user_type = 'admin';
            $user           = User::find($user_id);
        } else {
            $user_id        = \Auth::id();
            $user           = Customer::find($user_id);

            $user_type = 'customer';
        }
        $this->table    = 'notifications';
        $query          = DB::table($this->table);

        if (!$mode) {
            // safe mode is off
            $select = array(

                "$this->table.id",
                DB::raw("COUNT($this->table.n_type) as total"),
                "$this->table.n_type",
                "$this->table.data",
                "$this->table.read_at",
                "$this->table.updated_at",
            );
        } else {
            // safe mode is on
            $select = array(
                DB::raw("ANY_VALUE($this->table.id) as id"),
                DB::raw("COUNT($this->table.n_type) as total"),
                "$this->table.n_type",
                DB::raw("ANY_VALUE($this->table.data) as data"),
                DB::raw("ANY_VALUE($this->table.read_at) as read_at"),
                DB::raw("ANY_VALUE($this->table.updated_at) as updated_at"),
            );
        }

        $notifications  =   $query->select($select)
            ->where("$this->table.notifiable_id", $user_id)
            ->where(["$this->table.read_at" =>  null])
            ->where("$this->table.n_type", '!=',  null)
            ->where("$this->table.user_type", '=',  $user_type)
            ->groupBy("$this->table.n_type")
            ->get();

        $notifications  = to_array($notifications);

        return $notifications;
    }
}
