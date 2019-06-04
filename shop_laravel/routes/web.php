<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//index
Route::get('/', 'Merchandise\MerchandiseController@indexPage');

//user
Route::group(['prefix' => 'user'], function(){
    Route::group(['prefix' => 'auth'], function(){
        Route::get('/sign-up', 'User\UserAuthController@signUpPage');
        Route::post('/sign-up', 'User\UserAuthController@signUpProcess');
        Route::get('/sign-in', 'User\UserAuthController@signInPage');
        Route::post('/sign-in', 'User\UserAuthController@signInProcess');
        Route::get('/sign-out', 'User\UserAuthController@signOut');

        Route::get('/facebook-sign-in', 'User\UserAuthController@facebookSignInProcess');
        Route::get('/facebook-sign-in-callback', 'User\UserAuthController@facebookSignInCallbackProcess');
    });
});

//merchandise
Route::group(['prefix' => 'merchandise'], function(){
    Route::get('/', 'Merchandise\MerchandiseController@merchandiseListPage');
    Route::get('/create', 'Merchandise\MerchandiseController@merchandiseCreateProcess')->middleware(['user.auth.admin']);
    Route::get('/manage', 'Merchandise\MerchandiseController@merchandiseManageListPage')->middleware(['user.auth.admin']);

    //specifyMechandise
    Route::group(['prefix' => '{merchandise_id}'], function(){
        Route::get('/', 'Merchandise\MerchandiseController@merchandiseItemPage');
        Route::get('/edit', 'Merchandise\MerchandiseController@merchandiseItemEditPage')->middleware(['user.auth.admin']);
        Route::put('/', 'Merchandise\MerchandiseController@merchandiseItemUpdateProcess')->middleware(['user.auth.admin']);
        Route::post('/buy', 'Merchandise\MerchandiseController@merchandiseItemBuyProcess')->middleware(['user.auth']);
        Route::delete('/delete', 'Merchandise\MerchandiseController@merchandiseDeleteItem')->middleware(['user.auth.admin']);
    });
});

//transaction
Route::get('/transaction', 'Transaction\TransactionController@transactionListPage')->middleware(['user.auth']);