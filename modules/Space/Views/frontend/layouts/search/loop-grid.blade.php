<div class="card w-100 shadow-hover-3 mb-4">
	<a href="#" class="d-block mb-0 mx-1 mt-1 p-3" tabindex="0">
		<img class="card-img-top" src="{{$row->airline->image_url}}" alt="{{$row->airline->name}}">
	</a>
	<div class="card-body px-3 pt-0 pb-3 my-0 mx-1">
		<div class="row">
			<div class="col-7">
				<a href="#" class="card-title text-dark font-size-17 font-weight-bold" tabindex="0">{{$row->airportFrom->name}}</a>
			</div>
			<div class="col-5">
				<div class="text-right">
					<h6 class="font-weight-bold font-size-17 text-gray-3 mb-0">{{format_money(@$row->min_price)}}</h6>
					<span class="font-weight-normal font-size-12 d-block text-color-1">{{__('avg/person')}}</span>
				</div>
			</div>
		</div>
	</div>
	<div class="mb-3">
		<div class="border-bottom pb-3 mb-3">
			<div class="px-3">
				<div class="d-flex mx-1">
					<i class="icofont-school-bus font-size-30 text-primary mr-3"></i>
					<div class="d-flex flex-column">
						<span class="font-weight-normal text-gray-5">{{__('Take off')}}</span>
						<span class="font-size-14 text-gray-1">{{$row->departure_time->format("D M d H:i A")}}</span>
					</div>
				</div>
			</div>
		</div>
		<div class="border-bottom pb-3 mb-3">
			<div class="px-3">
				<div class="d-flex mx-1">
					<i class="d-block rotate-90 icofont-school-bus font-size-30 text-primary mr-3"></i>
					<div class="d-flex flex-column">
						<span class="font-weight-normal text-gray-5">{{__('Landing')}}</span>
						<span class="font-size-14 text-gray-1">{{$row->arrival_time->format("D M d H:i A")}}</span>
					</div>
				</div>
			</div>
		</div>
		<div class="d-flex justify-content-center pl-3 pr-3">
			@if($row->can_book)
			<a @click="openModalBook('{{$row->id}}')" href=""  onclick="event.preventDefault()" class="btn btn-primary text-white btn-choose w-100">{{__("Choose")}}</a>
			@else
				<a  href="#" class="btn btn-warning btn-disabled">{{__("Full Book")}}</a>
			@endif
		</div>
	</div>
</div>












{{-- @php
    $translation = $row->translateOrOrigin(app()->getLocale());
@endphp
<div class="item-loop {{$wrap_class ?? ''}}">
    @if($row->is_featured == "1")
        <div class="featured">
            {{__("Featured")}}
        </div>
    @endif
    <div class="thumb-image ">
        <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl($include_param ?? true)}}">
            @if($row->image_url)
                @if(!empty($disable_lazyload))
                    <img src="{{$row->image_url}}" class="img-responsive" alt="">
                @else
                    {!! get_image_tag($row->image_id,'medium',['class'=>'img-responsive','alt'=>$row->title]) !!}
                @endif
            @endif
        </a>
        <div class="price-wrapper">
            <div class="price">
                <span class="onsale">{{ $row->display_sale_price }}</span>
                <span class="text-price">
                    {{ $row->display_price }}
                    @if($row->getBookingType()=="by_day")
                        <span class="unit">{{__("/day")}}</span>
                    @else
                        <span class="unit">{{__("/night")}}</span>
                    @endif
                </span>
            </div>
        </div>
        <div class="service-wishlist {{$row->isWishList()}}" data-id="{{$row->id}}" data-type="{{$row->type}}">
            <i class="fa fa-heart"></i>
        </div>
    </div>
    <div class="item-title">
        <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl($include_param ?? true)}}">
            @if($row->is_instant)
                <i class="fa fa-bolt d-none"></i>
            @endif
                {!! clean($translation->title) !!}
        </a>
        @if($row->discount_percent)
            <div class="sale_info">{{$row->discount_percent}}</div>
        @endif
    </div>
    <div class="location">
        @if(!empty($row->location->name))
            @php $location =  $row->location->translateOrOrigin(app()->getLocale()) @endphp
            {{$location->name ?? ''}}
        @endif
    </div>
    @if(setting_item('space_enable_review'))
    <?php
    $reviewData = $row->getScoreReview();
    $score_total = $reviewData['score_total'];
    ?>
    <div class="service-review">
        <span class="rate">
            @if($reviewData['total_review'] > 0) {{$score_total}}/5 @endif <span class="rate-text">{{$reviewData['review_text']}}</span>
        </span>
        <span class="review">
             @if($reviewData['total_review'] > 1)
                {{ __(":number Reviews",["number"=>$reviewData['total_review'] ]) }}
            @else
                {{ __(":number Review",["number"=>$reviewData['total_review'] ]) }}
            @endif
        </span>
    </div>
    @endif
    <div class="amenities">
        @if($row->max_guests)
            <span class="amenity total" data-toggle="tooltip"  title="{{ __("No. People") }}">
                <i class="input-icon field-icon icofont-people  "></i> {{$row->max_guests}}
            </span>
        @endif
        @if($row->bed)
            <span class="amenity bed" data-toggle="tooltip" title="{{__("No. Bed")}}">
                <i class="input-icon field-icon icofont-hotel"></i> {{$row->bed}}
            </span>
        @endif
        @if($row->bathroom)
            <span class="amenity bath" data-toggle="tooltip" title="{{__("No. Bathroom")}}" >
                <i class="input-icon field-icon icofont-bathtub"></i> {{$row->bathroom}}
            </span>
        @endif
        @if($row->square)
            <span class="amenity size" data-toggle="tooltip" title="{{__("Square")}}" >
                <i class="input-icon field-icon icofont-ruler-compass-alt"></i> {!! size_unit_format($row->square) !!}
            </span>
        @endif
    </div>
</div> --}}
