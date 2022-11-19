<?php

namespace Classiebit\Eventmie\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Classiebit\Eventmie\Notifications\ForgotPasswordNotification;
use Classiebit\Eventmie\Models\Tag;
use Classiebit\Eventmie\Models\Venue;
use Illuminate\Support\Facades\Auth;

class Customer extends \TCG\Voyager\Models\User  implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function preferredLocale()
    {
        return \App::getLocale();
    }

    }
