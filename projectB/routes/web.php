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

//use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

Route::get('/',function(){
	return view('welcome');
});
Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '5',
        'redirect_uri' => 'http://websiteb.dev/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://websitea.dev/oauth/authorize?'.$query);
})->name('get.token');

Route::get('/callback', function (Request $request) {

   // $http = new GuzzleHttp\Client;
    $http = new Client();
    $response = $http->post('http://websitea.dev:8000/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '5',
            'client_secret' => 'NHZbq9Qm0kanpLFp6DakJBmGED9537dtk1utg7h3',
            'redirect_uri' => 'http://websiteb.dev/callback',
            'code' => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});

