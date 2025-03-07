<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\FamilyMemberController;

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

//Route::get('/', function () {    return view('welcome');    });
Route::get('/', function () {
    return redirect()->route('families.index'); 
});

Route::get('/families', [FamilyController::class, 'index'])->name('families.index');
Route::get('/families/create', [FamilyController::class, 'create'])->name('families.create');
Route::post('/families', [FamilyController::class, 'store'])->name('families.store');
Route::get('/families/{family}', [FamilyController::class, 'show'])->name('families.show');
Route::get('/families/{family}/edit', [FamilyController::class, 'edit'])->name('families.edit');

Route::get('/familiess/{family}', [FamilyController::class, 'profile'])->name('families.profile');

Route::put('/families/{family}', [FamilyController::class, 'update'])->name('families.update');
Route::delete('/families/{family}', [FamilyController::class, 'destroy'])->name('families.destroy');


Route::post('/families/{family}/members', [FamilyMemberController::class, 'store'])->name('family_members.store');
Route::get('/members/{member}/edit', [FamilyMemberController::class, 'edit'])->name('family_members.edit');
Route::put('/members/{member}', [FamilyMemberController::class, 'update'])->name('family_members.update');
Route::delete('/members/{member}', [FamilyMemberController::class, 'destroy'])->name('family_members.destroy');


Route::get('/members/{family}', [FamilyMemberController::class, 'index'])->name('family_members.show');

