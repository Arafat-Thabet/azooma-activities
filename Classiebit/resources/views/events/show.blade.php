@extends('eventmie::layouts.app')

@section('title', $event->title)
@section('meta_title', $event->meta_title)
@section('meta_keywords', $event->meta_keywords)
@section('meta_description', $event->meta_description)
@section('meta_image', '/storage/'.$event['thumbnail'])
@section('meta_url', url()->current())


@section('content')



<!--ABOUT-->
<section class="event">
    <div id="lgx-about" class="lgx-about">
        <div class="mt-30 mb-50 mt-mobile-0">
            <div class="container-fluid">
                <div class="row">



                    <div class="col-md-6">
                        <div class="lgx-about-content-area">
                            <div class="lgx-heading">
                                <h2 class="heading">{{ $event['title'] }}</h2>
                                <h3 class="subheading">
                                    @if(!empty($event['online_location']))
                                    <span class="lgx-badge lgx-badge-online"><i class="fas fa-signal"></i>&nbsp; @lang('eventmie-pro::em.online_event')</span>
                                    @endif

                                    <span class="lgx-badge lgx-badge-primary">{{ $category['name'] }}</span>

                                    @if(!empty($free_tickets))
                                    <span class="lgx-badge lgx-badge-primary">@lang('eventmie-pro::em.free_tickets')</span>
                                    @endif

                                    @if($event->repetitive)
                                    @if($event->repetitive_type == 1)
                                    <span class="lgx-badge lgx-badge-primary">
                                        @lang('eventmie-pro::em.repetitive_daily_event')
                                    </span>
                                    @elseif($event->repetitive_type == 2)
                                    <span class="lgx-badge lgx-badge-primary">
                                        @lang('eventmie-pro::em.repetitive_weekly_event')
                                    </span>
                                    @elseif($event->repetitive_type == 3)
                                    <span class="lgx-badge lgx-badge-primary">
                                        @lang('eventmie-pro::em.repetitive_monthly_event')
                                    </span>
                                    @endif

                                    @endif

                                    @if($ended)
                                    <span class="lgx-badge lgx-badge-danger">@lang('eventmie-pro::em.event_ended')</span>
                                    @endif
                                </h3>

                                <h3 class="subheading share-btns">
                                    <span><strong>@lang('eventmie-pro::em.share_event') &nbsp;</strong></span>

                                    <span><a class="btn btn-sm" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"><i class="fab fa-facebook-square"></i></a></span>
                                    <span><a class="btn btn-sm" target="_blank" href="https://twitter.com/intent/tweet?text={{ urlencode($event->title) }}&url={{ url()->current() }}"><i class="fab fa-twitter"></i></a></span>
                                    <span><a class="btn btn-sm" target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}&title={{ urlencode($event->title) }}"><i class="fab fa-linkedin"></i></a></span>
                                    <span><a class="btn btn-sm" target="_blank" href="https://wa.me/?text={{ url()->current() }}"><i class="fab fa-whatsapp"></i></a></span>
                                    <span><a class="btn btn-sm" target="_blank" href="https://www.reddit.com/submit?title={{ urlencode($event->title) }}&url={{ url()->current() }}"><i class="fab fa-reddit"></i></a></span>
                                    <span><a class="btn btn-sm" href="javascript:void(0)" onclick="copyToClipboard()"><i class="fas fa-link"></i></a></span>
                                </h3>



                            </div>
                            <div class="lgx-about-content">{!! $event['description'] !!}

                                <!--Event FAQ-->
                                @if($event['faq'])
                                <section>

                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="lgx-about-content-area text-center">
                                                <div class="lgx-about-content">{!! $event['faq'] !!}</div>
                                            </div>
                                        </div>
                                    </div>

                                </section>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 offset-md-1 visible-lg visible-md">
                        <div class="lgx-banner-info-area">
                            <!--SCHEDULE-->
                            <section>
                                <div id="buy-tickets" class="lgx-schedule1">
                                    <div class="py-1">

                                        <div class="container">


                                            <div class="row">

                                                <select-dates :event="{{ json_encode($event, JSON_HEX_APOS) }}" :max_ticket_qty="{{ json_encode($max_ticket_qty, JSON_HEX_APOS) }}" :login_user_id="{{ json_encode(\Auth::id(), JSON_HEX_APOS) }}" :is_customer="{{ Auth::id() ? (checkUserRole('customer') ? 1 : 0) : 1 }}" :is_organiser="{{isset(userInfo()->id) ? (checkUserRole('organiser') ? 1 : 0) : 0 }}" :is_admin="{{ isset(userInfo()->id) ? (checkUserRole('admin') ? 1 : 0) : 0 }}" :is_paypal="{{ $is_paypal }}" :is_offline_payment_organizer="{{ setting('booking.offline_payment_organizer') ? 1 : 0 }}" :is_offline_payment_customer="{{ setting('booking.offline_payment_customer') ? 1 : 0}}" :tickets="{{ json_encode($tickets, JSON_HEX_APOS) }}" :booked_tickets="{{ json_encode($booked_tickets, JSON_HEX_APOS) }}" :currency="{{ json_encode($currency, JSON_HEX_APOS) }}" :total_capacity="{{ $total_capacity }}" :date_format="{{ json_encode([
                            'vue_date_format' => format_js_date(),
                            'vue_time_format' => format_js_time()
                        ], JSON_HEX_APOS) }}">
                                                </select-dates>
                                            </div>
                                            <!--//.ROW-->
                                        </div>
                                        <!-- //.CONTAINER -->
                                    </div>
                                    <!-- //.INNER -->
                                </div>
                            </section>
                            <!--SCHEDULE END-->
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-12 col-sm-5 col-md-5 offset-md-1">

                        <div>
                            <div>@lang('eventmie-pro::em.where')
                                <span>
                                    @if(!empty($event['online_location']))
                                    <strong>@lang('eventmie-pro::em.online_event')</strong>
                                    @endif

                                    @if($event->venues->isNotEmpty())
                                    <a class="col-white" href="{{ route('eventmie.myvenues.show',[$event->venues[0]->id] ) }}"><strong>{{$event->venue}} <i class="fas fa-external-link-alt"></i></strong> </a>
                                    @else
                                    <strong>{{$event->venue}}</strong>
                                    @endif



                                    @if($event->address)
                                    {{$event->address}} {{ $event->zipcode }}
                                    @endif

                                    @if($event->city)
                                    {{ $event->city }},
                                    @endif

                                    @if($event->state)
                                    {{ $event->state }},
                                    @endif

                                    @if($country)
                                    {{ $country->get('country_name') }}
                                    @endif

                                </span>
                            </div>
                            <p class="title">@lang('eventmie-pro::em.when')

                                @if(!$event->repetitive)
                                <span>
                                    {{ userTimezone($event->start_date.' '.$event->start_time, 'Y-m-d H:i:s', format_carbon_date(false)) }}

                                    {{ '('. showTimezone() .')' }}

                                    @lang('eventmie-pro::em.till')

                                    {{ userTimezone($event->end_date.' '.$event->end_time, 'Y-m-d H:i:s', format_carbon_date(false)) }}

                                    {{ '('. showTimezone() .')' }}
                                </span>

                                @else
                                <span>
                                    {{ userTimezone($event->start_date.' '.$event->start_time, 'Y-m-d H:i:s', format_carbon_date(true)) }}

                                    @lang('eventmie-pro::em.till')

                                    {{ userTimezone($event->start_date.' '.$event->start_time, 'Y-m-d H:i:s', 'Y-m-d') <= userTimezone($event->end_date.' '.$event->end_time, 'Y-m-d H:i:s', 'Y-m-d') ? userTimezone($event->end_date.' '.$event->end_time, 'Y-m-d H:i:s', format_carbon_date(true)) : userTimezone($event->start_date.' '.$event->start_time, 'Y-m-d H:i:s', format_carbon_date(true))}}

                                </span>
                                @endif
                            <!-- </p>  -->
                        </div>
                    </div>
                    <div class="col-12 col-sm-5 col-md-5">


                    </div>

                </div>
            </div><!-- //.CONTAINER -->
        </div><!-- //.INNER -->
    </div>
</section>
<!--ABOUT END-->




<!--Event FAQ END-->




<!--PHOTO GALLERY-->
@if(!empty($event->images))
<section>
    <div id="lgx-photo-gallery" class="lgx-gallery-popup lgx-photo-gallery-normal lgx-photo-gallery-black">
        <div class="py-1">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="lgx-heading lgx-heading-white">
                            <h2 class="heading d-none">@lang('eventmie-pro::em.event_gallery')</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12">
                        <gallery-images :gimages="{{ $event->images }}"></gallery-images>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!--PHOTO GALLERY END-->

<!--Event Video-->
@if(!empty($event->video_link))
<section>
    <div id="lgx-travelinfo" class="lgx-travelinfo">
        <div class="py-1">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="lgx-heading">
                            <h2 class="heading">@lang('eventmie-pro::em.watch_trailer')</h2>
                        </div>
                    </div>
                    <!--//main COL-->
                </div>
                <div class="row">
                    <div class="col-md-offset-1 col-md-10">
                        <iframe src="https://www.youtube.com/embed/{{ $event->video_link }}" allowfullscreen style="width: 100%; height: 500px; border-radius: 16px; border: none;"></iframe>
                    </div>
                </div>
                <!--//.ROW-->
            </div>
            <!-- //.CONTAINER -->
        </div>
    </div>
</section>
@endif
<!--Event Video END-->


<!--GOOGLE MAP-->
@if($event->latitude && $event->longitude)
<div class="innerpage-section g-map-wrapper">
    <div class="lgxmapcanvas map-canvas-default">

        <g-component :lat="{{ json_encode($event->latitude, JSON_HEX_APOS) }}" :lng="{{ json_encode($event->longitude, JSON_HEX_APOS) }}">
        </g-component>

    </div>
</div>
@endif
<!--GOOGLE MAP END-->

@endsection

@section('javascript')

<script type="text/javascript" src="{{ eventmie_asset('js/events_show_v1.9.js') }}"></script>
<script type="text/javascript" src="{{ eventmie_asset('js/index.js') }}"></script>

<script type="text/javascript">
    var google_map_key = {
        !!json_encode($google_map_key) !!
    };
</script>
@stop