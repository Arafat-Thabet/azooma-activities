@extends('eventmie::layouts.app')

@section('title')
@lang('eventmie-pro::em.booking_details')
@endsection

@section('content')
<main>
    <div class="lgx-post-wrapper pt-0">
        <section>
            <div class="container">
                <div class="row" id="invoice_table">
                    <div class="text-end col-12 no-print" style="position: relative">
                        <button class="btn btn-success btn-sm " style="position: absolute;top: 20px;left: 15px;" onclick="print_report('invoice_table')"><i class="fa fa-print"></i> {{ __('Print') }}</button>
                    </div>

                    {{-- booking details --}}
                    <div class="col-md-6 table-responsive" id="first-table">
                        <h3>@lang('eventmie-pro::em.booking_info')</h3>
                        <table class="table table-striped table-hover">
                            <tr>
                                <th>@lang('eventmie-pro::em.order_id')</th>
                                <td>{{$booking['order_number']}}</td>
                            </tr>

                            <tr>
                                <th>@lang('eventmie-pro::em.event_category')</th>
                                <td>{{$booking['event_category']}}</td>
                            </tr>

                            <tr>
                                <th>@lang('eventmie-pro::em.event')</th>
                                <td>{{$booking['event_title']}}</td>
                            </tr>

                            <tr>
                                <th>@lang('eventmie-pro::em.repetitive')</th>
                                <td>{{$booking['event_repetitive'] == 0 ? 'No' : 'Yes'}}</td>
                            </tr>

                            <tr>
                                <th>@lang('eventmie-pro::em.ticket')</th>
                                <td>{{$booking['ticket_title']}}</td>
                            </tr>
                            <tr>
                                <th>@lang('eventmie-pro::em.ticket_price')</th>
                                <td>{{$booking['ticket_price']}}</td>
                            </tr>
                            <tr>
                                <th>@lang('eventmie-pro::em.total_amount_paid')</th>
                                <td>{{$booking['net_price'].' '.$currency}}</td>
                            </tr>

                            <tr>
                                <th>@lang('eventmie-pro::em.booking_date')</th>
                                <td>{{ userTimezone($booking['created_at'], 'Y-m-d H:i:s', format_carbon_date(true)) }}

                                </td>
                            </tr>

                            <tr>
                                <th>@lang('Booking status')</th>
                                <td><span class="label label-success">{{ $booking['status'] == 0 ? __('Inactive') :
                                        __('Active')}}</span></td>
                            </tr>

                            <tr>
                                <th>@lang('eventmie-pro::em.booking_cancellation')</th>
                                @if($booking['booking_cancel'] == 0)
                                <td><span class="label label-info"> @lang('eventmie-pro::em.no_cancellation')</span>
                                </td>

                                @elseif($booking['booking_cancel'] == 1)
                                <td><span class="label label-info">@lang('eventmie-pro::em.cancellation_pending')</span>
                                </td>

                                @elseif($booking['booking_cancel'] == 2)
                                <td><span
                                        class="label label-info">@lang('eventmie-pro::em.cancellation_approved')</span>
                                </td>

                                @elseif($booking['booking_cancel'] == 3)
                                <td><span class="label label-info">@lang('eventmie-pro::em.amount_refunded')</span></td>
                                @endif
                            </tr>

                            <tr>
                                <th>@lang('eventmie-pro::em.payment_type')</th>
                                <td>
                                    @if($booking['payment_type'] == 'offline')
                                    <span class="label label-default">{{ __($booking['payment_type']) }}</span>
                                    @else
                                    <span class="label label-success">{{ __($booking['payment_type']) }}</span>
                                    @endif
                                </td>

                            <tr>
                                <th>@lang('Paid') </th>
                                <td>

                                    @if($booking['is_paid'])

                                    <span class="label label-success"> @lang('eventmie-pro::em.yes') </span>
                                    @else
                                    <span class="label label-default"> @lang('eventmie-pro::em.no')</span>
                                    @endif
                                </td>
                            </tr>

                            </tr>

                        </table>
                    </div>

                    {{-- customer details --}}
                    <div class="col-md-6 table-responsive">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>@lang('eventmie-pro::em.customer_info')</h3>
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <th>@lang('Name')</th>
                                        <td>{{$customer->name}}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Email')</th>
                                        <td>{{$customer->email}}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Phone')</th>
                                        <td>{{$customer->phone}}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Nationality')</th>
                                        <td>{{$customer->c_nationality->country_name ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Identity Type')</th>
                                        <td>{{$customer->c_identityType->title}}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Identity No')</th>
                                        <td>{{$customer->identity_no}}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Diver Type')</th>
                                        <td>{{__(ucfirst($customer->diver_type))}}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Blood Type')</th>
                                        <?php $bt = ["1" => "O-","2" => "O+","3" => "A-","4" => "A+","5" => "B-","6" => "B+","7" => "AB-","8" => "AB+"]?>
                                        <td> <bdi> {{ $bt[$customer->blood_type] ?? ''}}</bdi></td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Diving License Level')</th>
                                        <td>{{$customer->c_licenseLevel->name}}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('License No')</th>
                                        <td>{{$customer->license_no}}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Diving License Date')</th>
                                        <td>{{ userTimezone($customer->diving_license_date, 'Y-m-d',
                                            format_carbon_date(true))}}

                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        {{-- payment information --}}
                        @if(!empty($payment))
                        <div class="row">
                            <div class="col-md-12">
                                <h3>@lang('eventmie-pro::em.payment_info')</h3>
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <th>@lang('eventmie-pro::em.transaction_id')</th>
                                        <td>{{$payment['txn_id']}}</td>
                                    </tr>

                                    <tr>
                                        <th>@lang('eventmie-pro::em.payment_type')</th>
                                        <td>{{$payment['payment_gateway']}}</td>
                                    </tr>

                                    <tr>
                                        <th>@lang('eventmie-pro::em.payment_status')</th>
                                        <td>{{ $payment['payment_status'] }}</td>
                                    </tr>

                                    <tr>
                                        <th>@lang('eventmie-pro::em.total_amount_paid')</th>
                                        <td>{{$payment['amount_paid']}} {{$payment['currency_code']}}</td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                        @endif

                    </div>

                </div>
                @yield('eventmie-bookings-show')
            </div>
        </section>
    </div>
</main>

<div class="print_box" id="print_box"></div>
@endsection
