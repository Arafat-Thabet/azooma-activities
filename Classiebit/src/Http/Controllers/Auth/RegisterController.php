<?php

namespace Classiebit\Eventmie\Http\Controllers\Auth;

use Facades\Classiebit\Eventmie\Eventmie;

use App\Http\Controllers\Controller;
use Classiebit\Eventmie\Models\Country;
use Classiebit\Eventmie\Models\Customer;
use Classiebit\Eventmie\Models\IdentityType;
use Classiebit\Eventmie\Models\LicenseLevel;
use Classiebit\Eventmie\Models\RelativeType;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Classiebit\Eventmie\Models\User;
use Classiebit\Eventmie\Notifications\MailNotification;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // language change
        $this->middleware('common');
        $this->middleware('guest');
        $this->middleware('guest:customer');

        $this->redirectTo = \URL::previous();
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        \Session::put('url.intended', \URL::previous());
        $data['countries'] = Country::all();
        $data['identity_types'] = IdentityType::all();
        $data['relative_types'] = RelativeType::all();
        $data['license_levels'] = LicenseLevel::all();
        
        return Eventmie::view('eventmie::auth.register', $data);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {

        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));


        $this->guard()->login($user);


        if ($response = $this->registered($request, $user)) {

            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect(\URL::previous());
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers'],
            'nationality' => ['required', 'max:255'],
            'birth_date' => ['required', 'date'],
            'identity_type' => ['required', 'integer'],
            'identity_no' => ['required', 'string'],
            'diver_type' => ['required', 'string', 'max:30'],
            'phone' => ['required', 'string', 'max:30'],
            'other_phone' => [ 'string', 'max:30'],
            'relative_relation' => [ 'integer'],
            'relative_name' => [ 'string', 'max:255'],
            'blood_type' => [ 'integer', 'max:8'],
            'address' => [ 'string', 'max:255'],
            'diving_license_level' => [ 'integer'],
            'license_no' => [ 'string'],
            'diving_license_date' => ['required', 'date'],
            'password' => ['required', 'string', 'min:8'],
            'accept' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user   = Customer::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'nationality' => $data['nationality'],
            'birth_date' => $data['birth_date'],
            'identity_type' => $data['identity_type'],
            'identity_no' =>$data['identity_no'],
            'diver_type' => $data['diver_type'],
            'phone' => $data['phone'],
            'other_phone' =>$data['other_phone'],
            'relative_relation' => $data['relative_relation'],
            'relative_name' => $data['relative_name'],
            'blood_type' => $data['blood_type'],
            'address' => $data['address'],
            'diving_license_level' =>$data['diving_license_level'],
            'license_no' => $data['license_no'],
            'diving_license_date' => $data['diving_license_date'],
        
            'role_id'  => 2,
        ]);

        // Send welcome email
        if (!empty($user->id)) {
            // ====================== Notification ====================== 
            $mail['mail_subject']   = __('eventmie-pro::em.register_success');
            $mail['mail_message']   = __('eventmie-pro::em.get_tickets');
            $mail['action_title']   = __('eventmie-pro::em.login');
            $mail['action_url']     = eventmie_url();
            $mail['n_type']         = "user";

            // notification for
            $notification_ids       = [
                1, // admin
                $user->id, // new registered user
            ];

            $users = Customer::whereIn('id', $notification_ids)->get();
            if (checkMailCreds()) {
                try {
                    \Notification::locale(\App::getLocale())->send($users, new MailNotification($mail));
                } catch (\Throwable $th) {
                }
            }
            // ====================== Notification ======================     
        }

        $this->redirectTo = \Session::get('url.intended');

        return $user;
    }
}
