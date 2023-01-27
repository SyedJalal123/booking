<div class="row">
    <div class="col-lg-3 col-md-12">
        @include('Space::frontend.layouts.search.filter-search')
    </div>
    <div class="col-lg-9 col-md-12">
        <div class="bravo-list-item">
            {{-- <div class="topbar-search">
                <h2 class="text"> --}}
            <div class="d-flex justify-content-between align-items-center mb-4 topbar-search">
                <h3 class="font-size-21 font-weight-bold mb-0 text-lh-1">
                    @if($rows->total() > 1)
                        {{ __(":count buses found",['count'=>$rows->total()]) }}
                    @else
                        {{ __(":count bus found",['count'=>$rows->total()]) }}
                    @endif
                </h3>
                {{-- </h2> --}}
                <div class="control">
                    @include('Space::frontend.layouts.search.orderby')
                </div>
            </div>
            <div class="list-item" id="flightFormBook">
                <div class="row">
                    @if($rows->total() > 0)
                        @foreach($rows as $row)
                            <div class="col-lg-4 col-md-6">
                                @include('Space::frontend.layouts.search.loop-grid')
                            </div>
                        @endforeach
                    @else
                        <div class="col-lg-12">
                            {{__("Bus not found")}}
                        </div>
                    @endif
                </div>
            </div>
            @include('Space::frontend.layouts.search.modal-form-book')
            
            <div class="bravo-pagination">
                {{$rows->appends(request()->query())->links()}}
                @if($rows->total() > 0)
                    <span class="count-string">{{ __("Showing :from - :to of :total Spaces",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()]) }}</span>
                @endif
            </div>
        </div>
    </div>
</div>