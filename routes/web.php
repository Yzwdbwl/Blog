<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', 'IndexController@index');
Route::any('{class}/{action}.html', ['as' => 'home', function($class, $action)
{
    $class = 'App\\Http\\Controllers\\Home\\'.ucfirst(strtolower($class)).'Controller';
    if(class_exists($class))
    {
        $classObject = new $class();
        if(method_exists($classObject, $action))
        {
            $return = call_user_func(array($classObject, $action));
            if( ! $return instanceof \Illuminate\Http\Response)
            {
                $cacheSecond = config('home.cache_control');
                $time = date('D, d M Y H:i:s', time() + $cacheSecond) . ' GMT';
                return response($return)->header('Cache-Control', 'max-age='.$cacheSecond)->header('Expires', $time);
            }
            return $return;
        }
    }
    return abort(404);
}])->where(['class' => '[0-9a-z]+', 'action' => '[0-9a-z]+']);



