@extends('eventmie::layouts.app')


@section('content')

<main>
    <div class="mx-3 my-3">
        <section>
            <div class="container-fuild">
                <div class="row justify-content-center">
                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-body">
                                <div class="h3 mt-0 text-center"> @lang('eventmie-pro::em.profile')
                                </div>
                                <form class="form-horizontal" action="{{ route('eventmie.adminupdateAuthUser')}}" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row {{ $errors->has('name') ? ' has-error' : '' }}">
                                                <label class="col-md-3">@lang('eventmie-pro::em.name') <span class="required"> *</span></label>
                                                <div class="col-md-9">
                                                    <input class="form-control" name="name" type="text" value="{{$user->name}}">

                                                    @if ($errors->has('name'))
                                                    <div class="error">{{ $errors->first('name') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-3">@lang('eventmie-pro::em.email') <span class="required"> *</span></label>
                                                <div class="col-md-9">
                                                    <input class="form-control" name="email" type="email" value="{{$user->email}}">
                                                    @if ($errors->has('email'))
                                                    <div class="error">{{ $errors->first('email') }}</div>
                                                    @endif
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-md-3">@lang('eventmie-pro::em.address')</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" name="address" type="text" value="{{$user->address}}">
                                                    @if ($errors->has('address'))
                                                    <div class="error">{{ $errors->first('address') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-3">@lang('eventmie-pro::em.phone')</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" name="phone" type="text" value="{{$user->phone}}">
                                                    @if ($errors->has('phone'))
                                                    <div class="error">{{ $errors->first('phone') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- only for organiser --}}
                                            @if(checkUserRole('organiser'))
                                            <div class="form-group row">
                                                <label class="col-md-3">@lang('eventmie-pro::em.organization') <span class="required"> *</span></label>
                                                <div class="col-md-9">
                                                    <input class="form-control" name="organisation" type="text" value="{{$user->organisation}}" required>
                                                    @if ($errors->has('organisation'))
                                                    <div class="error">{{ $errors->first('organisation') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif

                                            <hr>
                                            <h4>@lang('eventmie-pro::em.update_password') </h4>
                                            <hr>

                                            <div class="form-group row">
                                                <label class="col-md-3">@lang('eventmie-pro::em.current_password')</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" name="current" type="password">
                                                    @if ($errors->has('current'))
                                                    <div class="error">{{ $errors->first('current') }}</div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-3"> @lang('eventmie-pro::em.new_password')</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" name="password" type="password">
                                                    @if ($errors->has('password'))
                                                    <div class="error">{{ $errors->first('password') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-3">@lang('eventmie-pro::em.confirm_password')</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" name="password_confirmation" type="password">
                                                    @if ($errors->has('password_confirmation'))
                                                    <div class="error">{{ $errors->first('password_confirmation') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">



                                            {{-- only for organiser and admin --}}
                                            @if(!userInfo()->hasRole('customer'))

                                            <h4>@lang('eventmie-pro::em.update_bank_details')</h4>
                                            <hr>
                                            <div class="form-group row">
                                                <label class="col-md-3">@lang('eventmie-pro::em.bank_name')</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" name="bank_name" type="text" value="{{$user->bank_name}}">
                                                    @if ($errors->has('bank_name'))
                                                    <div class="error">{{ $errors->first('bank_name') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-3">@lang('eventmie-pro::em.bank_code')</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" name="bank_code" type=text" value="{{$user->bank_code}}">
                                                    @if ($errors->has('bank_code'))
                                                    <div class="error">{{ $errors->first('bank_code') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-3">@lang('eventmie-pro::em.bank_branch_name')</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" name="bank_branch_name" type="text" value="{{$user->bank_branch_name}}">
                                                    @if ($errors->has('bank_branch_name'))
                                                    <div class="error">{{ $errors->first('bank_branch_name') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-3">@lang('eventmie-pro::em.bank_branch_code')</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" name="bank_branch_code" type="text" value="{{$user->bank_branch_code}}">
                                                    @if ($errors->has('bank_branch_code'))
                                                    <div class="error">{{ $errors->first('bank_branch_code') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-3">@lang('eventmie-pro::em.bank_account_number')</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" name="bank_account_number" type="text" value="{{$user->bank_account_number}}">
                                                    @if ($errors->has('bank_account_number'))
                                                    <div class="error">{{ $errors->first('bank_account_number') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-3">@lang('eventmie-pro::em.bank_account_name')</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" name="bank_account_name" type="text" value="{{$user->bank_account_name}}">
                                                    @if ($errors->has('bank_account_name'))
                                                    <div class="error">{{ $errors->first('bank_account_name') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-3">@lang('eventmie-pro::em.bank_account_phone')</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" name="bank_account_phone" type="text" value="{{$user->bank_account_phone}}">
                                                    @if ($errors->has('bank_account_phone'))
                                                    <div class="error">{{ $errors->first('bank_account_phone') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                            @yield('eventmie-profile-profile')

                                            @endif

                                            <div class="form-group row text-center">
                                                
                                                <div class="col-md-12">
                                                    <button class="lgx-btn" type="submit"><i class="fas fa-sd-card"></i> @lang('eventmie-pro::em.update')</button>
                                                </div>
                                            </div>
                                </form>

                                <hr>
                                {{-- if logged in user is customer and multi-vendor mode is enabled --}}
                                @if(false && userInfo()->hasRole('customer'))
                                @if(setting('multi-vendor.multi_vendor'))

                                @if((setting('multi-vendor.manually_approve_organizer') && empty($user->organisation)) || !setting('multi-vendor.manually_approve_organizer'))

                                <div class="form-group row">
                                    <label class="col-md-3">@lang('eventmie-pro::em.want_to_create_host')</label>
                                    <div class="col-md-9">
                                        <button type="button" class="lgx-btn lgx-btn-black lgx-btn-sm" data-toggle="modal" data-target="#myModal"><i class="fas fa-person-booth"></i> @lang('eventmie-pro::em.become_organiser')</button>
                                    </div>
                                </div>
                                @endif
                                @endif

                                @if(setting('multi-vendor.manually_approve_organizer') && !empty($user->organisation))
                                <div class="alert alert-info" role="alert">
                                    <strong>@lang('eventmie-pro::em.become_organiser_notification')</strong>
                                </div>
                                @endif
                                @endif

                                <!-- Modal -->

                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel">@lang('eventmie-pro::em.become_organiser')</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert alert-info">
                                                    <h4>@lang('eventmie-pro::em.info')</h4>
                                                    <ul>
                                                        <li>@lang('eventmie-pro::em.organiser_note_1')</li>
                                                        <li>@lang('eventmie-pro::em.organiser_note_2')</li>
                                                        <li>@lang('eventmie-pro::em.organiser_note_3')</li>
                                                        <li>@lang('eventmie-pro::em.organiser_note_4')</li>
                                                    </ul>
                                                </div>
                                                <form class="form-horizontal" action="{{ route('eventmie.updateAuthUserRole')}}" method="post">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="role_id" value="3">

                                                    <div class="form-group row">
                                                        <label class="col-md-3">@lang('eventmie-pro::em.organization')</label>
                                                        <div class="col-md-9">
                                                            <input class="form-control" name="organisation" type="text" placeholder="@lang('eventmie-pro::em.brand_identity')" value="{{$user->organisation}}">

                                                            @if ($errors->has('organisation'))
                                                            <div class="error">{{ $errors->first('organisation') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                          
                                        <div class="form-group row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-9 text-start">
                                                <button type="submit" class="lgx-btn"><i class="fas fa-sd-card"></i> @lang('eventmie-pro::em.submit')</button>
                                            </div>
                                        </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
    </div>
    </div>
    </section>
    </div>
</main>
@endsection

@section('javascript')
<script type="text/javascript" src="{{ eventmie_asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ eventmie_asset('js/bootstrap.min.js') }}"></script>
@stop