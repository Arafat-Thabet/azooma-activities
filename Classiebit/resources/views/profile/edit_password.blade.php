@extends('eventmie::layouts.app')


@section('content')

<main>
    <section class="user-profile mx-3 my-3">
        <div class="container-fuild">
            <div class="row justify-content-center">
                <div class="col-md-6">

                    <div class="card">

                        <div class="card-body">
                            <div class="h3 mt-0 text-center"> @lang('eventmie-pro::em.update_password')
                            </div>
                            <form class="form-horizontal" action="{{ route('eventmie.updateUserPassword')}}" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      
                                
                                        <div class="form-group row {{ $errors->has('current') ? ' has-error' : '' }}">
                                            <label class="col-md-3">@lang('eventmie-pro::em.current_password')</label>
                                            <div class="col-md-9">
                                                <input class="form-control" name="current" type="password">
                                                @if ($errors->has('current'))
                                                <div class="error">{{ $errors->first('current') }}</div>
                                                @endif

                                            </div>
                                        </div>

                                        <div class="form-group row {{ $errors->has('password') ? ' has-error' : '' }}">
                                            <label class="col-md-3"> @lang('eventmie-pro::em.new_password')</label>
                                            <div class="col-md-9">
                                                <input class="form-control" name="password" type="password">
                                                @if ($errors->has('password'))
                                                <div class="error">{{ $errors->first('password') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                            <label class="col-md-3">@lang('eventmie-pro::em.confirm_password')</label>
                                            <div class="col-md-9">
                                                <input class="form-control" name="password_confirmation" type="password">
                                                @if ($errors->has('password_confirmation'))
                                                <div class="error">{{ $errors->first('password_confirmation') }}</div>
                                                @endif
                                            </div>
                                            </div>
                               


                                    <div class="form-group row text-start">

                                        <div class="col-md-3"></div>
                                        <div class="col-md-9">
                                            <button class="lgx-btn" type="submit"><i class="fas fa-sd-card"></i> @lang('eventmie-pro::em.update')</button>
                                        </div>
                                    </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('javascript')
<script type="text/javascript" src="{{ eventmie_asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ eventmie_asset('js/bootstrap.min.js') }}"></script>
@stop