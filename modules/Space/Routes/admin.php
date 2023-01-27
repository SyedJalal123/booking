<?php

use \Illuminate\Support\Facades\Route;


Route::get('/','BusController@index')->name('space.admin.index');
Route::get('/create','BusController@create')->name('space.admin.create');
Route::get('/edit/{id}','BusController@edit')->name('space.admin.edit');
Route::post('/store/{id}','BusController@store')->name('space.admin.store');
Route::post('/bulkEdit','BusController@bulkEdit')->name('space.admin.bulkEdit');
Route::get('/recovery','BusController@recovery')->name('space.admin.recovery');

Route::group(['prefix'=>'{flight_id}/flight-seat'],function (){
    Route::get('/','BusSeatController@index')->name('space.admin.space.seat.index');
    Route::get('edit/{id}','BusSeatController@edit')->name('space.admin.space.seat.edit');
    Route::post('store/{id}','BusSeatController@store')->name('space.admin.space.seat.store');
    Route::post('/bulkEdit','BusSeatController@bulkEdit')->name('space.admin.space.seat.bulkEdit');
});
Route::group(['prefix'=>'bus-companies'],function (){
    Route::get('/','BusCompaniesController@index')->name('space.admin.bus_companies.index');
    Route::get('edit/{id}','BusCompaniesController@edit')->name('space.admin.bus_companies.edit');
    Route::post('store/{id}','BusCompaniesController@store')->name('space.admin.bus_companies.store');
    Route::post('/bulkEdit','BusCompaniesController@bulkEdit')->name('space.admin.bus_companies.bulkEdit');
});
Route::group(['prefix'=>'bus-stops'],function (){
    Route::get('/','BusStopsController@index')->name('space.admin.bus_stops.index');
    Route::get('edit/{id}','BusStopsController@edit')->name('space.admin.bus_stops.edit');
    Route::post('store/{id}','BusStopsController@store')->name('space.admin.bus_stops.store');
    Route::post('/bulkEdit','BusStopsController@bulkEdit')->name('space.admin.bus_stops.bulkEdit');

});
Route::group(['prefix'=>'bus-seat-type'],function (){
    Route::get('/','BusSeatTypeController@index')->name('space.admin.seat_type.index');
    Route::get('edit/{id}','BusSeatTypeController@edit')->name('space.admin.seat_type.edit');
    Route::post('store/{id}','BusSeatTypeController@store')->name('space.admin.seat_type.store');
    Route::post('/bulkEdit','BusSeatTypeController@bulkEdit')->name('space.admin.seat_type.bulkEdit');

});
Route::group(['prefix'=>'attribute'],function (){
    Route::get('/','AttributeController@index')->name('space.admin.attribute.index');
    Route::get('edit/{id}','AttributeController@edit')->name('space.admin.attribute.edit');
    Route::post('store/{id}','AttributeController@store')->name('space.admin.attribute.store');
    Route::post('/editAttrBulk','AttributeController@editAttrBulk')->name('space.admin.attribute.bulkEdit');

    Route::get('terms/{id}','AttributeController@terms')->name('space.admin.attribute.term.index');
    Route::get('term_edit/{id}','AttributeController@term_edit')->name('space.admin.attribute.term.edit');
    Route::match(['get','post'],'term_store','AttributeController@term_store')->name('space.admin.attribute.term.store');
    Route::post('/editTermBulk','AttributeController@editTermBulk')->name('space.admin.attribute.editTermBulk');
});


























// Route::get('/','SpaceController@index')->name('space.admin.index');
// Route::get('/create','SpaceController@create')->name('space.admin.create');
// Route::get('/edit/{id}','SpaceController@edit')->name('space.admin.edit');
// Route::post('/store/{id}','SpaceController@store')->name('space.admin.store');
// Route::post('/bulkEdit','SpaceController@bulkEdit')->name('space.admin.bulkEdit');
// Route::get('/recovery','SpaceController@recovery')->name('space.admin.recovery');
// Route::get('/getForSelect2','SpaceController@getForSelect2')->name('space.admin.getForSelect2');
// Route::get('/getForSelect2','SpaceController@getForSelect2')->name('space.admin.getForSelect2');


// Route::group(['prefix'=>'attribute'],function (){
//     Route::get('/','AttributeController@index')->name('space.admin.attribute.index');
//     Route::get('edit/{id}','AttributeController@edit')->name('space.admin.attribute.edit');
//     Route::post('store/{id}','AttributeController@store')->name('space.admin.attribute.store');
//     Route::post('/editAttrBulk','AttributeController@editAttrBulk')->name('space.admin.attribute.editAttrBulk');


//     Route::get('terms/{id}','AttributeController@terms')->name('space.admin.attribute.term.index');
//     Route::get('term_edit/{id}','AttributeController@term_edit')->name('space.admin.attribute.term.edit');
//     Route::post('term_store','AttributeController@term_store')->name('space.admin.attribute.term.store');
//     Route::post('/editTermBulk','AttributeController@editTermBulk')->name('space.admin.attribute.term.editTermBulk');

//     Route::get('getForSelect2','AttributeController@getForSelect2')->name('space.admin.attribute.term.getForSelect2');
// });

// Route::group(['prefix'=>'availability'],function(){
//     Route::get('/','AvailabilityController@index')->name('space.admin.availability.index');
//     Route::get('/loadDates','AvailabilityController@loadDates')->name('space.admin.availability.loadDates');
//     Route::post('/store','AvailabilityController@store')->name('space.admin.availability.store');
// });