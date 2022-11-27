@extends('eventmie::layouts.app')


@section('content')
<div class="user-profile">

  <div class="row">
    <div class="col-12">
      <div class="card" style="border-radius: 15px;">
        <div class="card-body p-0">
          <h2 class="title text-center h3 mb-0">@lang('eventmie-pro::em.profile')</h2>

          <form method="POST" action="{{ route('eventmie.updateAuthUser') }}">
            @csrf
            @honeypot
            <div class="row g-0">
              <div class="col-lg-6">
                <div class="py-2 px-4">
                  <h3 class="fw-normal h4 mb-2">{{__('General Infomation')}}</h3>

                  <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('Name')}} <span class="required"> *</span></label>
                    <input class="form-control select-input placeholder-active active" type="text" name="name" value="{{ $user->name }}" required autofocus />
                    <div class="invalid-feedback">
                      {{ $errors->first('name') }}
                    </div>
                  </div>
                  <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} ">
                    <label class="form-label text-start">{{__('Email')}} <span class="required"> *</span></label>
                    <input type="email" class="form-control select-input placeholder-active active is-invalid" name="email" value="{{$user->email }}" required />
                    <div class="invalid-feedback">
                      {{ $errors->first('email') }}
                    </div>
                  </div>
                  <div class="form-group  {{ $errors->has('nationality') ? ' has-error' : '' }} ">
                    <label class="form-label text-start">{{__('Nationality')}} <span class="required"> *</span></label>
                    <select class="form-control select-input placeholder-active active " name="nationality" required>
                      <option value="">..</option>

                      @foreach($countries as $c)
                      <option value="{{$c->id}}" {{ $c->id==$user->nationality ?"selected":"" }}>{{$c->country_name}}</option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback">
                      {{ $errors->first('nationality') }}
                    </div>
                  </div>

                  <div class="form-group text-start {{ $errors->has('birth_date') ? ' has-error' : '' }}">
                    <label class="form-label js-datepicker-label ">{{__('Birth Date')}} <span class="required"> *</span></label>
                    <input class="form-control select-input placeholder-active js-datepicker active" type="text" autocomplete="off" readonly name="birth_date" value="{{$user->birth_date }}" required />
                    <div class="invalid-feedback">
                      {{ $errors->first('birth_date') }}
                    </div>
                  </div>
                  <div class="form-group {{ $errors->has('identity_type') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('Identity Type')}} <span class="required"> *</span></label>
                    <select class="form-control" name="identity_type" required>
                      @foreach($identity_types as $v)
                      <option value="{{$v->id}}" {{ $v->id==$user->identity_type ?"selected":"" }}>{{$v->title}}</option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback">
                      {{ $errors->first('identity_type') }}
                    </div>
                  </div>

                  <div class="form-group {{ $errors->has('identity_no') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('Identity No')}} <span class="required"> *</span></label>
                    <input class="form-control select-input placeholder-active active" type="text" name="identity_no" value="{{$user->identity_no }}" required />
                    <div class="invalid-feedback">
                      {{ $errors->first('identity_no') }}
                    </div>
                  </div>
                  <div class="form-group {{ $errors->has('diver_type') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('Diver Type')}} <span class="required"> *</span></label>
                    <select class="form-control" name="diver_type" required>
                      <option value="diver" {{ 'diver'==$user->diver_type ?"selected":"" }}>{{__('Diver')}}</option>
                      <option value="under_training" {{ 'under_training'==$user->diver_type ?"selected":"" }}>{{__('Under Training')}}</option>
                      <option value="other" {{ 'other'==$user->diver_type ?"selected":"" }}>{{__('Other')}}</option>
                    </select>
                    <div class="invalid-feedback">
                      {{ $errors->first('diver_type') }}
                    </div>
                  </div>
                  <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('Phone')}} <span class="required"> *</span></label>
                    <input class="form-control select-input placeholder-active active" type="text" name="phone" value="{{$user->phone }}" required />
                    <div class="invalid-feedback">
                      {{ $errors->first('phone') }}
                    </div>
                  </div>




                </div>
              </div>
              <div class="col-lg-6 bg-indigo text-white">
                <div class="p-2">
                  <h3 class="fw-normal h4 mb-2">{{__('Optional Infomation')}}</h3>

                  <div class="form-group {{ $errors->has('other_phone') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('Other Phone')}} </label>
                    <input class="form-control select-input placeholder-active active" type="text" name="other_phone" value="{{$user->other_phone }}" />
                    <div class="invalid-feedback">
                      {{ $errors->first('other_phone') }}
                    </div>
                  </div>
                  <div class="form-group {{ $errors->has('relative_relation') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('Relative Relation')}} </label>
                    <select class="form-control" name="relative_relation">
                      <option value="">..</option>
                      @foreach($relative_types as $v)
                      <option value="{{$v->id}}" {{ $v->id==$user->relative_relation ?"selected":"" }}>{{$v->title}}</option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback">
                      {{ $errors->first('relative_relation') }}
                    </div>
                  </div>
                  <div class="form-group {{ $errors->has('relative_name') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('Relative Name')}} </label>
                    <input class="form-control select-input placeholder-active active" type="text" name="relative_name" value="{{$user->relative_name }}" />
                    <div class="invalid-feedback">
                      {{ $errors->first('relative_name') }}
                    </div>
                  </div>
                  <div class="form-group {{ $errors->has('blood_type') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('Blood Type')}} </label>
                    <select class="form-control" name="blood_type">
                      <option value="">..</option>
                      <option value="1" {{ '1'==$user->blood_type ?"selected":"" }}>O-</option>
                      <option value="2" {{ '2'==$user->blood_type ?"selected":"" }}>O+</option>
                      <option value="3" {{ '3'==$user->blood_type ?"selected":"" }}>A-</option>
                      <option value="4" {{ '4'==$user->blood_type ?"selected":"" }}>A+</option>
                      <option value="5" {{ '5'==$user->blood_type ?"selected":"" }}>B-</option>
                      <option value="6" {{ '6'==$user->blood_type ?"selected":"" }}>B+</option>
                      <option value="7" {{ '7'==$user->blood_type ?"selected":"" }}>AB-</option>
                      <option value="8" {{ '8'==$user->blood_type ?"selected":"" }}>AB+</option>
                    </select>
                    <div class="invalid-feedback">
                      {{ $errors->first('blood_type') }}
                    </div>
                  </div>

                  <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('Home Address')}} </label>
                    <input class="form-control select-input placeholder-active active" type="text" name="address" value="{{$user->address }}" />
                    <div class="invalid-feedback">
                      {{ $errors->first('address') }}
                    </div>
                  </div>
                  <div class="form-group {{ $errors->has('diving_license_level') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('Diving License Level')}} </label>
                    <select class="form-control" name="diving_license_level">
                      <option value="">..</option>
                      @foreach($license_levels as $v)
                      <option value="{{$v->id}}" {{ $v->id==$user->diving_license_level ?"selected":"" }}>{{$v->name}}</option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback">
                      {{ $errors->first('diving_license_level') }}
                    </div>
                  </div>
                  <div class="form-group {{ $errors->has('license_no') ? ' has-error' : '' }}">
                    <label class="form-label text-start">{{__('License No')}} </label>
                    <input class="form-control select-input placeholder-active active" type="text" name="license_no" value="{{$user->license_no }}" />
                    <div class="invalid-feedback">
                      {{ $errors->first('license_no') }}
                    </div>
                  </div>

                  <div class="form-group  mb-0 text-start {{ $errors->has('diving_license_date') ? ' has-error' : '' }}">
                    <label class="form-label js-datepicker-label ">{{__('Diving License Date')}} </label>
                    <input class="form-control select-input placeholder-active js-datepicker active" type="text" readonly name="diving_license_date" value="{{$user->diving_license_date }}" />
                    <div class="invalid-feedback">
                      {{ $errors->first('diving_license_date') }}
                    </div>
                  </div>
           
            
               

                </div>
              </div>
           
            </div>
            <div class="form-group d-block mx-1 text-end">
                    <button type="submit" class="btn btn-primary  btn-lg px-5" data-mdb-ripple-color="dark">{{__('Update')}}</button>
                  </div>
        </div>


  
        </form>
      </div>
    </div>
  </div>
<link rel="stylesheet" href="{{ eventmie_asset('css/datepicker.min.css') }}">

  @endsection
  @section('javascript')
  <script src="{{ eventmie_asset('js/datepicker.min.js') }}" ></script>
  @if(is_rtl())

  <script src="{{ eventmie_asset('js/datepicker.ar-ae.min.js') }}"></script>
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