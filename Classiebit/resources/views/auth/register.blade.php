@extends('eventmie::auth.authapp')

@section('title')
@lang('eventmie-pro::em.register')
@endsection

@section('authcontent')
<div class="lgx-registration-form">

  <div class="row">
    <div class="col-12">
      <div class="card card-registration card-registration-2" style="border-radius: 15px;">
        <div class="card-body p-0">
          <h2 class="title mb-0">@lang('eventmie-pro::em.register')</h2>

          <form method="POST" action="{{ route('eventmie.register') }}">
            @csrf
            @honeypot
            <div class="row g-0">
              <div class="col-lg-6">
                <div class="py-2 px-4">
                  <h3 class="fw-normal mb-2">{{__('General Infomation')}}</h3>

                  <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('Name')}} <span class="required"> *</span></label>
                    <input class="form-control select-input placeholder-active active" type="text" name="name" value="{{ old('name') }}" required autofocus />
                    <div class="invalid-feedback">
                      {{ $errors->first('name') }}
                    </div>
                  </div>
                  <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} ">
                    <label class="form-label text-start">{{__('Email')}} <span class="required"> *</span></label>
                    <input type="email" class="form-control select-input placeholder-active active is-invalid" name="email" value="{{ old('email') }}" required />
                    <div class="invalid-feedback">
                      {{ $errors->first('email') }}
                    </div>
                  </div>
                  <div class="form-group  {{ $errors->has('nationality') ? ' has-error' : '' }} ">
                    <label class="form-label text-start">{{__('Nationality')}} <span class="required"> *</span></label>
                    <select class="form-control select-input placeholder-active active " name="nationality" required>
                      <option value="">..</option>

                      @foreach($countries as $c)
                      <option value="{{$c->id}}" {{ $c->id==old('nationality') ?"selected":"" }}>{{$c->country_name}}</option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback">
                      {{ $errors->first('nationality') }}
                    </div>
                  </div>

                  <div class="form-group text-start {{ $errors->has('birth_date') ? ' has-error' : '' }}">
                    <label class="form-label js-datepicker-label ">{{__('Birth Date')}} <span class="required"> *</span></label>
                    <input class="form-control select-input placeholder-active js-datepicker active" type="text" autocomplete="off" readonly name="birth_date" value="{{ old('birth_date') }}" required />
                    <div class="invalid-feedback">
                      {{ $errors->first('birth_date') }}
                    </div>
                  </div>
                  <div class="form-group {{ $errors->has('identity_type') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('Identity Type')}} <span class="required"> *</span></label>
                    <select class="form-control" name="identity_type" required>
                      @foreach($identity_types as $v)
                      <option value="{{$v->id}}" {{ $v->id==old('identity_type') ?"selected":"" }}>{{$v->title}}</option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback">
                      {{ $errors->first('identity_type') }}
                    </div>
                  </div>

                  <div class="form-group {{ $errors->has('identity_no') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('Identity No')}} <span class="required"> *</span></label>
                    <input class="form-control select-input placeholder-active active" type="text" name="identity_no" value="{{ old('identity_no') }}" required />
                    <div class="invalid-feedback">
                      {{ $errors->first('identity_no') }}
                    </div>
                  </div>
                  <div class="form-group {{ $errors->has('diver_type') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('Diver Type')}} <span class="required"> *</span></label>
                    <select class="form-control" name="diver_type" required>
                      <option value="diver" {{ 'diver'==old('diver_type') ?"selected":"" }}>{{__('Diver')}}</option>
                      <option value="under_training" {{ 'under_training'==old('diver_type') ?"selected":"" }}>{{__('Under Training')}}</option>
                      <option value="other" {{ 'other'==old('diver_type') ?"selected":"" }}>{{__('Other')}}</option>
                    </select>
                    <div class="invalid-feedback">
                      {{ $errors->first('diver_type') }}
                    </div>
                  </div>
                  <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('Phone')}} <span class="required"> *</span></label>
                    <input class="form-control select-input placeholder-active active" type="text" name="phone" value="{{ old('phone') }}" required />
                    <div class="invalid-feedback">
                      {{ $errors->first('phone') }}
                    </div>
                  </div>




                </div>
              </div>
              <div class="col-lg-6 bg-indigo text-white">
                <div class="p-2">
                  <h3 class="fw-normal mb-2">{{__('Optional Infomation')}}</h3>

                  <div class="form-group {{ $errors->has('other_phone') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('Other Phone')}} </label>
                    <input class="form-control select-input placeholder-active active" type="text" name="phone" value="{{ old('other_phone') }}" />
                    <div class="invalid-feedback">
                      {{ $errors->first('other_phone') }}
                    </div>
                  </div>
                  <div class="form-group {{ $errors->has('relative_relation') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('Relative Relation')}} </label>
                    <select class="form-control" name="relative_relation">
                      <option value="">..</option>
                      @foreach($relative_types as $v)
                      <option value="{{$v->id}}" {{ $v->id==old('relative_relation') ?"selected":"" }}>{{$v->title}}</option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback">
                      {{ $errors->first('relative_relation') }}
                    </div>
                  </div>
                  <div class="form-group {{ $errors->has('relative_name') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('Relative Name')}} </label>
                    <input class="form-control select-input placeholder-active active" type="text" name="relative_name" value="{{ old('relative_name') }}" />
                    <div class="invalid-feedback">
                      {{ $errors->first('relative_name') }}
                    </div>
                  </div>
                  <div class="form-group {{ $errors->has('blood_type') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('Blood Type')}} </label>
                    <select class="form-control" name="blood_type">
                      <option value="">..</option>
                      <option value="1" {{ '1'==old('blood_type') ?"selected":"" }}>O-</option>
                      <option value="2" {{ '2'==old('blood_type') ?"selected":"" }}>O+</option>
                      <option value="3" {{ '3'==old('blood_type') ?"selected":"" }}>A-</option>
                      <option value="4" {{ '4'==old('blood_type') ?"selected":"" }}>A+</option>
                      <option value="5" {{ '5'==old('blood_type') ?"selected":"" }}>B-</option>
                      <option value="6" {{ '6'==old('blood_type') ?"selected":"" }}>B+</option>
                      <option value="7" {{ '7'==old('blood_type') ?"selected":"" }}>AB-</option>
                      <option value="8" {{ '8'==old('blood_type') ?"selected":"" }}>AB+</option>
                    </select>
                    <div class="invalid-feedback">
                      {{ $errors->first('blood_type') }}
                    </div>
                  </div>

                  <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('Home Address')}} </label>
                    <input class="form-control select-input placeholder-active active" type="text" name="address" value="{{ old('address') }}" />
                    <div class="invalid-feedback">
                      {{ $errors->first('address') }}
                    </div>
                  </div>
                  <div class="form-group {{ $errors->has('diving_license_level') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('Diving License Level')}} </label>
                    <select class="form-control" name="diving_license_level">
                      <option value="">..</option>
                      @foreach($license_levels as $v)
                      <option value="{{$v->id}}" {{ $v->id==old('diving_license_level') ?"selected":"" }}>{{$v->name}}</option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback">
                      {{ $errors->first('diving_license_level') }}
                    </div>
                  </div>
                  <div class="form-group {{ $errors->has('license_no') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('License No')}} </label>
                    <input class="form-control select-input placeholder-active active" type="text" name="license_no" value="{{ old('license_no') }}" />
                    <div class="invalid-feedback">
                      {{ $errors->first('license_no') }}
                    </div>
                  </div>

                  <div class="form-group  mb-0 text-start {{ $errors->has('diving_license_date') ? ' has-error' : '' }}">
                    <label class="form-label js-datepicker-label ">{{__('Diving License Date')}} </label>
                    <input class="form-control select-input placeholder-active js-datepicker active" type="text" readonly name="diving_license_date" value="{{ old('diving_license_date') }}" />
                    <div class="invalid-feedback">
                      {{ $errors->first('diving_license_date') }}
                    </div>
                  </div>
                  <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('Password')}} <span class="required"> *</span></label>

                    <input id="password" type="password" class="wpcf7-form-control form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="@lang('eventmie-pro::em.password')">
                    <div class="invalid-feedback">
                      {{ $errors->first('password') }}
                    </div>
                  </div>
                  <div class="form-check form-check-inline text-right">
                    <input class="form-check-input d-inline" type="checkbox" name="accept" id="accept" required value="1">
                    <label class="form-check-label d-inline" for="accept">@lang('eventmie-pro::em.accept_terms')</label>
                  </div>
                  <div class="form-group  mt-1 text-start">
                    <button type="submit" class="btn btn-primary  btn-lg px-5" data-mdb-ripple-color="dark">{{__('Register')}}</button>
                    <a class="btn btn-link" href="{{ route('eventmie.login') }}">
                      @lang('eventmie-pro::em.login')
                    </a>
                  </div>

                </div>
              </div>
            </div>
        </div>


        <hr style="border-top: 2px solid #eee;">
        @if(!empty(config('services')['facebook']['client_id']) || !empty(config('services')['google']['client_id']))
        <div class="row">
          <div class="col-md-4 text-left">
            <h4 class="col-white">@lang('eventmie-pro::em.continue_with')</h4>
          </div>
          <div class="col-md-8 text-right">
            @if(!empty(config('services')['facebook']['client_id']))
            <a href="{{ route('eventmie.oauth_login', ['social' => 'facebook'])}}" class="lgx-btn lgx-btn-white lgx-btn-sm"><i class="fab fa-facebook-f"></i> Facebook</a>
            @endif

            @if(!empty(config('services')['google']['client_id']))
            <a href="{{ route('eventmie.oauth_login', ['social' => 'google'])}}" class="lgx-btn lgx-btn-white lgx-btn-sm"><i class="fab fa-google"></i> Google</a>
            @endif
          </div>
        </div>
        @endif
        </form>
      </div>
    </div>
  </div>
<link rel="stylesheet" href="{{ eventmie_asset('css/datepicker.min.css') }}">

  @endsection
  @section('javascript')
  <script src="{{ eventmie_asset('js/datepicker.min.js') }}" ></script>
  @if(is_rtl())

  <script src="{{ eventmie_asset('js/datepicker.ar-AE.min.js') }}"></script>
  
    @endif
    <script>
    $(document).ready(function() {
      $('.js-datepicker').datepicker({
        language: 'ar-AE',
        format: 'yyyy-mm-dd',
        autoHide:true,
        inline:true

      });
    })
  </script>
  @stop