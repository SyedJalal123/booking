<div class="d-block d-md-flex flex-center-between align-items-start mb-3">
    <div class="mb-3">
        <div class="d-block d-md-flex flex-horizontal-center mb-2 mb-md-0">
            <h4 class="font-size-23 font-weight-bold mb-1 mr-3">{!! clean($translation->title) !!}</h4>
            @if($row->getReviewEnable())
                <span class="font-size-14 text-primary mr-2">{{ $review_score['score_total'] }}/5 {{$review_score['score_text']}}</span>
                <span class="font-size-14 text-gray-1 ml-1">{{__(":number reviews",['number'=>$review_score['total_review']])}}</span>
            @endif

        </div>
        <div class="d-block d-md-flex flex-horizontal-center font-size-14 text-gray-1">
            @if($translation->address)
                <i class="icon flaticon-placeholder mr-2 font-size-20"></i>
                {{ $translation->address }}
            @endif
            @if($row->map_lat && $row->map_lng)
                <a target="_blank" href="https://www.google.com/maps/place/{{$row->map_lat}},{{$row->map_lng}}/@<?php echo $row->map_lat ?>,{{$row->map_lng}},{{!empty($row->map_zoom) ? $row->map_zoom : 12}}z" class="ml-1 d-block d-md-inline">
                    - {{__('View on map')}}
                </a>
            @endif
        </div>
    </div>
    <ul class="list-group list-group-borderless list-group-horizontal custom-social-share">
        <li class="list-group-item px-1">
            <a href="#" class="height-45 width-45 border rounded border-width-2 flex-content-center">
                <i class="flaticon-like font-size-18 text-dark"></i>
            </a>
        </li>
        <li class="list-group-item px-1">
            <a href="#" class="height-45 width-45 border rounded border-width-2 flex-content-center">
                <i class="flaticon-share font-size-18 text-dark"></i>
            </a>
        </li>
    </ul>
</div>

<div class="py-4 border-top border-bottom mb-4">
    <ul class="list-group list-group-borderless list-group-horizontal flex-center-between text-center mx-md-4 flex-wrap">
        @if($row->square)
            <li class="list-group-item text-lh-sm ">
                <i class="flaticon-plans text-primary font-size-50 mb-1 d-block"></i>
                <div class="text-gray-1">{!! size_unit_format($row->square) !!}</div>
            </li>
        @endif
        <li class="list-group-item text-lh-sm ">
            <i class="flaticon-door text-primary font-size-50 mb-1 d-block"></i>
            <div class="text-gray-1"> {{$row->max_guests}} {{ __("People") }}</div>
        </li>
        @if($row->bathroom)
            <li class="list-group-item text-lh-sm ">
                <i class="flaticon-bathtub text-primary font-size-50 mb-1 d-block"></i>
                <div class="text-gray-1"> {{$row->bathroom}} {{ __("bathrooms") }}</div>
            </li>
        @endif
        @if(!empty($row->bed))
            <li class="list-group-item text-lh-sm ">
                <i class="flaticon-bed-1 text-primary font-size-50 mb-1 d-block"></i>
                <div class="text-gray-1">{{$row->bed}} {{ __("beds") }}</div>
            </li>
        @endif
    </ul>
</div>
@if($translation->content)
    <div class="border-bottom position-relative">
        <h5 class="font-size-21 font-weight-bold text-dark">
            {{ __("Description") }}
        </h5>
        <div class="description">
            <?php echo $translation->content ?>
        </div>
    </div>
@endif
@include('Space::frontend.layouts.details.space-attributes')
@include('Space::frontend.layouts.details.space-faqs')
@includeIf("Hotel::frontend.layouts.details.hotel-surrounding")
@if($row->map_lat && $row->map_lng)
    <div class="border-bottom py-4">
        <h5 class="font-size-21 font-weight-bold text-dark mb-4">
            {{ __("Location") }}
        </h5>
        <div class="location-map">
            <div id="map_content"></div>
        </div>
    </div>
@endif
@include('Space::frontend.layouts.details.space-video')






{{-- <div class="g-header">
    <div class="left">
        <h1>{!! clean($translation->title) !!}</h1>
        @if($translation->address)
            <p class="address"><i class="fa fa-map-marker"></i>
                {{$translation->address}}
            </p>
        @endif
    </div>
    <div class="right">
        @if($row->getReviewEnable())
            @if($review_score)
                <div class="review-score">
                    <div class="head">
                        <div class="left">
                            <span class="head-rating">{{$review_score['score_text']}}</span>
                            <span class="text-rating">{{__("from :number reviews",['number'=>$review_score['total_review']])}}</span>
                        </div>
                        <div class="score">
                            {{$review_score['score_total']}}<span>/5</span>
                        </div>
                    </div>
                    <div class="foot">
                        {{__(":number% of guests recommend",['number'=>$row->recommend_percent])}}
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
<div class="g-space-feature">
    <div class="row">
        @if(!empty($row->bed))
            <div class="col-xs-6 col-lg-3 col-md-6">
                <div class="item">
                    <div class="icon">
                        <i class="icofont-hotel"></i>
                    </div>
                    <div class="info">
                        <h4 class="name">{{__("No. Bed")}}</h4>
                        <p class="value">
                            {{$row->bed}}
                        </p>
                    </div>
                </div>
            </div>
        @endif
        @if($row->bathroom)
            <div class="col-xs-6 col-lg-3 col-md-6">
                <div class="item">
                    <div class="icon">
                        <i class="icofont-bathtub"></i>
                    </div>
                    <div class="info">
                        <h4 class="name">{{__("No. Bathroom")}}</h4>
                        <p class="value">
                            {{$row->bathroom}}
                        </p>
                    </div>
                </div>
            </div>
        @endif
            @if($row->square)
            <div class="col-xs-6 col-lg-3 col-md-6">
                <div class="item">
                    <div class="icon">
                        <i class="icofont-ruler-compass-alt"></i>
                    </div>
                    <div class="info">
                        <h4 class="name">{{__("Square")}}</h4>
                        <p class="value">
                            {!! size_unit_format($row->square) !!}
                        </p>
                    </div>
                </div>
            </div>
        @endif
        @if(!empty($row->location->name))
                @php $location =  $row->location->translateOrOrigin(app()->getLocale()) @endphp
            <div class="col-xs-6 col-lg-3 col-md-6">
                <div class="item">
                    <div class="icon">
                        <i class="icofont-island-alt"></i>
                    </div>
                    <div class="info">
                        <h4 class="name">{{__("Location")}}</h4>
                        <p class="value">
                            {{$location->name ?? ''}}
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@if($row->getGallery())
    <div class="g-gallery">
        <div class="fotorama" data-width="100%" data-thumbwidth="135" data-thumbheight="135" data-thumbmargin="15" data-nav="thumbs" data-allowfullscreen="true">
            @foreach($row->getGallery() as $key=>$item)
                <a href="{{$item['large']}}" data-thumb="{{$item['thumb']}}" data-alt="{{ __("Gallery") }}"></a>
            @endforeach
        </div>
        <div class="social">
            <div class="social-share">
                <span class="social-icon">
                    <i class="icofont-share"></i>
                </span>
                <ul class="share-wrapper">
                    <li>
                        <a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank" rel="noopener" original-title="{{__("Facebook")}}">
                            <i class="fa fa-facebook fa-lg"></i>
                        </a>
                    </li>
                    <li>
                        <a class="twitter" href="https://twitter.com/share?url={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank" rel="noopener" original-title="{{__("Twitter")}}">
                            <i class="fa fa-twitter fa-lg"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="service-wishlist {{$row->isWishList()}}" data-id="{{$row->id}}" data-type="{{$row->type}}">
                <i class="fa fa-heart-o"></i>
            </div>
        </div>
    </div>
@endif
@if($translation->content)
    <div class="g-overview">
        <h3>{{__("Description")}}</h3>
        <div class="description">
            <?php echo $translation->content ?>
        </div>
    </div>
@endif
@include('Space::frontend.layouts.details.space-attributes')
@if($translation->faqs)
<div class="g-faq">
    <h3> {{__("FAQs")}} </h3>
    @foreach($translation->faqs as $item)
        <div class="item">
            <div class="header">
                <i class="field-icon icofont-support-faq"></i>
                <h5>{{$item['title']}}</h5>
                <span class="arrow"><i class="fa fa-angle-down"></i></span>
            </div>
            <div class="body">
                {{$item['content']}}
            </div>
        </div>
    @endforeach
</div>
@endif
@includeIf("Hotel::frontend.layouts.details.hotel-surrounding")
@if($row->map_lat && $row->map_lng)
<div class="g-location">
    <h3>{{__("Location")}}</h3>
    <div class="location-map">
        <div id="map_content"></div>
    </div>
</div>
@endif --}}
