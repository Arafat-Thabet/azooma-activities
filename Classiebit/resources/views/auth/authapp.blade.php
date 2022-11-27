@extends('eventmie::layouts.app')

@section('content')

<!--BANNER-->
<section>
    <div id="lgx-schedule" class="lgx-schedule lgx-schedule-dark">
        <div class="lgx-registration-form-box lgx-registration-banner-box" style="background-image: url('{{ eventmie_asset('img/loginbg3.jpg') }}');background-size:cover;">
            <!--lgx-registration-banner-box-->
            @yield('authcontent')
        </div>

        <!-- //.CONTAINER -->

        <!-- //.INNER -->
    </div>
</section>
<!--BANNER END-->

@endsection