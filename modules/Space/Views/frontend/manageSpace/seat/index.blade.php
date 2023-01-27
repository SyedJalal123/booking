@extends('layouts.user')
@section('head')

@endsection
@section('content')
    <h2 class="title-bar">
        {{__("Manage Seats")}}
        <div class="title-action">
            <a href="{{route('space.vendor.edit',['id'=>$currentFlight->id])}}" class="btn btn-info"><i class="fa fa-hand-o-right"></i> {{__("Back to bus")}}</a>
            <a href="{{ route("space.vendor.seat.create",['flight_id'=>$currentFlight->id]) }}" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> {{__("Add Seat")}}</a>
        </div>
    </h2>
    @include('admin.message')
    <div class="row">
        <div class="col-md-4 mb40">
            <div class="panel">
                <div class="panel-title">{{__("Add Bus Seat")}}</div>
                <div class="panel-body">
                    <form action="{{route('space.vendor.seat.store',['flight_id'=>$currentFlight->id,'id'=>$row->id??-1])}}" method="post">
                        @csrf
                        @include('Space::admin.space.seat.form')
                        <div class="">
                            <button class="btn btn-primary" type="submit">{{__("Add new")}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="filter-div d-flex justify-content-between mb-4">
                <div class="col-left">
                    @if(!empty($rows))
                        <form method="post" action="{{route('space.vendor.seat.bulkEdit',['flight_id'=>$currentFlight->id])}}" class="filter-form filter-form-left d-flex justify-content-start">
                            {{csrf_field()}}
                            <select name="action" class="form-control ">
                                <option value="">{{__(" Bulk Action ")}}</option>
                                <option value="delete">{{__(" Delete ")}}</option>
                            </select>
                            <input type="hidden" name="idss" id="idss">
                            <button data-confirm="{{__("Do you want to delete?")}}" class="btn-info btn btn-sm dungdt-apply-form-btn ml-3" type="submit">{{__('Apply')}}</button>
                        </form>
                    @endif
                </div>
                <div class="col-left">
                    <form method="get" action="{{route('space.vendor.seat.index',['flight_id'=>$currentFlight->id])}} " class="filter-form filter-form-right d-flex justify-content-end" role="search">
                        <input type="text" name="s" value="{{ Request()->s }}" class="form-control" placeholder="{{__("Search by code")}}">
                        <button class="btn btn-info btn-sm ml-2" id="search-submit" type="submit">{{__('Search')}}</button>
                    </form>
                </div>
            </div>
            <div class="panel">
                <div class="panel-title">{{__("All Bus seat")}}</div>
                <div class="panel-body">
                    <form class="bravo-form-item">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th width="60px"><input type="checkbox" class="check-all"></th>
                                <th>{{__("Bus id")}}</th>
                                <th>{{__("Seat type")}}</th>
                                <th >{{__("Price")}}</th>
                                <th >{{__("Max passengers")}}</th>
                                <th class="date"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach ($rows as $key => $row)
                                    <tr>
                                        <td><input type="checkbox" onclick="add_id({{$key}})" id="check_item_{{$key}}" class="check-item" name="ids[]" value="{{$row->id}}"></td>
                                        <td><a href="{{route('space.admin.edit',$row->flight)}}">#{{$row->flight->id}}</a></td>
                                        <td>{{$row->seatType->name}}</td>
                                        <td>{{format_money($row->price)}}</td>
                                        <td>{{$row->max_passengers}}</td>
                                        <td><a class="btn btn-primary btn-sm" href="{{route('space.vendor.seat.edit',['flight_id'=>$currentFlight->id,'id'=>$row->id])}}"><i class="fa fa-edit"></i> {{__('Edit')}}</a></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">{{__("No data")}}</td>
                                </tr>
                            @endif
                            </tbody>
                            {{$rows->appends(request()->query())->links()}}
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
<script>
    // function add_id(id){
    //     var ids =  $("input[name^='ids']").serializeArray();
    //     console.log(ids);
    // }
</script>
@endsection
