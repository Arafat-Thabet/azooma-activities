<form method="POST" action="{{ route('eventmie.save_escort') }}">
    @csrf
<div class="modal-body">
<h4 class="title">@lang('Booking escorts') {{$booking->event_title}}</h4>


    <input type="hidden" name="booking_id" value="{{$id}}"/>
    <select class="form-control select2" multiple name="escort[]">


        @foreach($escorts as $v)
        <option value="{{ $v->id }}" @if(in_array($v->id,$ids))
            {{ 'selected="selected"' }}
            @endif
            >
            {{ $v->name }}
        </option>
        @endforeach
    </select>
    </div>
    <div class="modal-footer">
    <div class=" text-start">
        <button type="submit" class="btn btn-primary  btn-lg px-5" >{{__('Save')}}</button>

    </div>
    </div>
</form>


<link rel="stylesheet" href="{{ eventmie_asset('css/select2.min.css') }}">

<script type="text/javascript" src="{{ eventmie_asset('js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ eventmie_asset('js/index.js') }}"></script>
