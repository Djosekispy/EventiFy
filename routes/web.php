<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ParticipantController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [EventController::class, 'index']);


Route::get('/interest',function(){
    return view('home.interests');
});

Route::get('/events',function(){
    return view('home.events');
});




Route::get('/search',[EventController::class,'search']);
Route::get('/deteils/{id}',[EventController::class, 'show']);
Route::post('/invite',[EventController::class,'sendEmail']);
Route::get('/search/category/{categoryId}', [EventController::class, 'searchByCategory'])->name('search.category');
Route::get('/search/event-type/{eventTypeId}', [EventController::class, 'searchByEventType'])->name('search.event-type');
// Rotas de Formulário de Evento



Route::get('/galery', [EventController::class, 'galery']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return redirect('/');;
    })->name('dashboard');

    Route::get('/logout', function (Request $request) {
        $user = Auth::user();

    if ($user->currentAccessToken() instanceof \Laravel\Sanctum\TransientToken) {
        Auth::guard('web')->logout();

        return redirect()->back();
    }
    $user->currentAccessToken()->delete();
       return redirect()->back();
    });
    Route::get('/showAll', [EventController::class, 'showAll'])->name('your.event');

    //User Routes to managemant events
    Route::prefix('event')->group(function () {
        Route::get('/form', [EventController::class, 'create']);
        Route::post('/banner', [EventController::class, 'addImage']);
        Route::post('/ticket', [EventController::class, 'ticket']);
        Route::post('/review', [EventController::class, 'review']);
        Route::post('/save', [EventController::class, 'store']);
    });

    Route::get('/delete/{id}', [EventController::class, 'destroy'])->name('delete');

    Route::get('/participate/{id}', [ParticipantController::class, 'show'])->name('participate');

    Route::get('/profile',function(){
        return view('auth.profile');
    });
    Route::post('/updateProfile', [UserController::class, 'updateProfile']);
    Route::post('/updatePassword', [UserController::class, 'updatePassword']);
    Route::post('/updateEmail', [UserController::class, 'updateEmail']);
});
