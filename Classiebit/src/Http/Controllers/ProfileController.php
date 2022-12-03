<?php

namespace Classiebit\Eventmie\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Classiebit\Eventmie\Models\Country;
use Classiebit\Eventmie\Models\Customer;
use Classiebit\Eventmie\Models\IdentityType;
use Classiebit\Eventmie\Models\LicenseLevel;
use Classiebit\Eventmie\Models\RelativeType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Classiebit\Eventmie\Models\User;
use Facades\Classiebit\Eventmie\Eventmie;

use Classiebit\Eventmie\Notifications\MailNotification;

class ProfileController extends Controller
{

    public function __construct()
    {
        // language change
        $this->middleware('common');

        $this->middleware('auth:customer');
    }

    public function index($view = 'eventmie::profile.profile', $extra = [])
    {
        $user  = $this->getAuthUser();
        $data['countries'] = Country::all();
        $data['identity_types'] = IdentityType::all();
        $data['relative_types'] = RelativeType::all();
        $data['license_levels'] = LicenseLevel::all();
        $data['user'] = $user;
        $data['extra'] = $extra;
        return Eventmie::view($view, $data);
    }

    // get login user
    public function getAuthUser()
    {

        return Auth::guard('customer')->user();
    }

    // update user
    public function updateAuthUser(Request $request)
    {
        // demo mode restrictions


        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . this_user(),
            'nationality' => ['required', 'max:255'],
            'birth_date' => ['required', 'date'],
            'identity_type' => ['required', 'integer'],
            'identity_no' => ['required', 'string'],
            'diver_type' => ['required', 'string', 'max:30'],
            'phone' => ['required', 'string', 'max:30'],
            'other_phone' => ['string', 'max:30'],
            'relative_relation' => ['integer'],
            'relative_name' => ['string', 'max:255'],
            'blood_type' => ['integer', 'max:8'],
            'address' => ['string', 'max:255'],
            'diving_license_level' => ['integer'],
            'license_no' => ['string'],
            'diving_license_date' => ['required', 'date'],
        ]);

   

        $user = Customer::find(this_user());

        $user->name                  = $request->name;
        $user->email                 = $request->email;
        $user->nationality =   $request->nationality;
        $user->birth_date =   $request->birth_date;
        $user->identity_type =   $request->identity_type;
        $user->identity_no = $request->identity_no;
        $user->diver_type = $request->diver_type;
        $user->phone = $request->phone;
        $user->other_phone = $request->other_phone;
        $user->relative_relation = $request->relative_relation;
        $user->relative_name = $request->relative_name;
        $user->blood_type = $request->blood_type;
        $user->address = $request->address;
        $user->diving_license_level = $request->diving_license_level;
        $user->license_no = $request->license_no;
        $user->diving_license_date = $request->diving_license_date;

        $user->save();

        // redirect no matter what so that it never turns back
        $msg = __('eventmie-pro::em.saved') . ' ' . __('eventmie-pro::em.successfully');
        return success_redirect($msg, route('eventmie.profile'));
    }
    public function edit_password($view = 'eventmie::profile.edit_password', $extra = [])
    {
        $user  = $this->getAuthUser();
        $data['countries'] = Country::all();
        $data['identity_types'] = IdentityType::all();
        $data['relative_types'] = RelativeType::all();
        $data['license_levels'] = LicenseLevel::all();
        $data['user'] = $user;
        $data['extra'] = $extra;
        return Eventmie::view($view, $data);
    }
    // reset password
    public function updateUserPassword(Request $request)
    {
   
     
        $this->validate($request, [
            'current' => 'required|current_password',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = Customer::find(this_user());

        if (!Hash::check($request->current, $user->password)) {
            return error_redirect( __('eventmie-pro::em.current_password_not_match'));
        }


        $user->password = Hash::make($request->password);
        $user->save();
        $msg = __('eventmie-pro::em.saved') . ' ' . __('eventmie-pro::em.successfully');
        return success_redirect($msg, route('eventmie.profile'));
    }

    // update user role
    public function updateAuthUserRole(Request $request)
    {
        $this->validate($request, [
            'organisation'  => 'required',
        ]);

        $manually_approve_organizer = (int)setting('multi-vendor.manually_approve_organizer');


        $user = Customer::find(this_user());

        // manually aporove organizer setting on then don't change role
        if (empty($manually_approve_organizer)) {
            $user->role_id      = 3;
        }

        $user->organisation = $request->organisation;

        $user->save();

        // ====================== Notification ====================== 
        // Manual Organizer approval email
        $msg[]                  = __('eventmie-pro::em.name') . ' - ' . $user->name;
        $msg[]                  = __('eventmie-pro::em.email') . ' - ' . $user->email;
        $extra_lines            = $msg;

        $mail['mail_subject']   = __('eventmie-pro::em.requested_to_become_organiser');
        $mail['mail_message']   = __('eventmie-pro::em.become_organiser_notification');
        $mail['action_title']   = __('eventmie-pro::em.view') . ' ' . __('eventmie-pro::em.profile');
        $mail['action_url']     = route('eventmie.profile');
        $mail['n_type']         = "Approve-Organizer";
        if (empty($manually_approve_organizer)) {
            // Became Organizer successfully email
            $msg[]                  = __('eventmie-pro::em.name') . ' - ' . $user->name;
            $msg[]                  = __('eventmie-pro::em.email') . ' - ' . $user->email;
            $extra_lines            = $msg;

            $mail['mail_subject']   = __('eventmie-pro::em.became_organiser_successful');
            $mail['mail_message']   = __('eventmie-pro::em.became_organiser_successful_msg');
            $mail['action_title']   = __('eventmie-pro::em.view') . ' ' . __('eventmie-pro::em.profile');
            $mail['action_url']     = route('eventmie.profile');
            $mail['n_type']         = "Approved-Organizer";
        }

        // notification for
        $notification_ids       = [
            1, // admin
            $user->id, // logged in user by
        ];

        $users = Customer::whereIn('id', $notification_ids)->get();
        try {
            \Notification::locale(\App::getLocale())->send($users, new MailNotification($mail, $extra_lines));
        } catch (\Throwable $th) {
        }
        // ====================== Notification ====================== 


        return redirect()->route('eventmie.profile');
    }


}
