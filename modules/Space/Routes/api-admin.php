<?php
    Route::group(['prefix'=>'bus-companies'],function (){
        Route::get('/getForSelect2','BusCompaniesController@getForSelect2')->name('space.admin.bus_companies.getForSelect2');
    });
    Route::group(['prefix'=>'bus-stops'],function (){
        Route::get('/getForSelect2','BusStopsController@getForSelect2')->name('space.admin.bus_stops.getForSelect2');
    });
    Route::group(['prefix'=>'bus-seat-type'],function (){
        Route::get('getForSelect2','BusSeatTypeController@getForSelect2')->name('space.admin.seat_type.getForSelect2');
    });
    Route::group(['prefix'=>'attribute'],function (){
        Route::get('getForSelect2','AttributeController@getForSelect2')->name('space.admin.attribute.term.getForSelect2');
    });
    ;?>