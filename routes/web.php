<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
 
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

// Route::get('/', function () {
//     return view('layouts.app');
// });

// Route::get('/student', function () {
//     return view('student.index');
// });
Route::get('/',[studentController::class, 'index']);
Route::get('/fetchStudent',[studentController::class, 'fetchStudent'])->name('fetchStudent');

Route::post('/store',[studentController::class, 'store'])->name('students.store');
Route::get('/edit',[studentController::class, 'edit'])->name('student.edit');
Route::put('/update',[studentController::class, 'update'])->name('student.update');
Route::delete('/delete',[studentController::class, 'destroy'])->name('student.delete');
