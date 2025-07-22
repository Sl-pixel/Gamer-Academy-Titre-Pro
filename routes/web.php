<?php

use App\Http\Controllers\CoachController;
use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController; 
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



Route::post('/login', [AuthController::class, 'loginUser'])->name('loginUser');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'registerForm'])->name('registerForm');
Route::post('/doRegisterUser', [AuthController::class, 'registerUser'])->name('registerUser');
// logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::get('/selectCoach', [HomeController::class, 'selectCoach'])->name('selectCoach');

Route::get('/contact', [HomeController::class, 'contactForm'])->name('contact');
// Route::get('/discord', [HomeController::class, 'discord'])->name('discord');


// fiche user
Route::get('/admin/user/{id}/user-Info', [AdminController::class, 'showUserInfo'])->name('showUserInfo');
Route::get('/admin/user/{id}/show-Notes', [AdminController::class, 'showNotes'])->name('showNotes');
Route::get('/admin/coaching/{id}/coaching-Info', [AdminController::class, 'showCoachingInfo'])->name('showCoachingInfo');
Route::get('/admin/demande/{id}/Demande-Info', [AdminController::class, 'showDemandeInfo'])->name('showDemandeInfo');

// edit user
Route::get('/admin/user/{id}/edit', [AdminController::class, 'editUser'])->name('editUser');
// edit demande
Route::get('/admin/demande/{id}/edit', [AdminController::class, 'editDemande'])->name('editDemande');

// edit coaching
Route::get('/admin/coaching/{id}/edit', [AdminController::class, 'editCoaching'])->name('editCoaching');
Route::get('/admin/coaching/{id}/update', [AdminController::class, 'updateCoaching'])->name('updateCoaching');


// dashboard
Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('adminDashboard');
Route::get('/student/dashboard/{user}', [UserController::class, 'studentDashboard'])->name('studentDashboard');
Route::get('/coach/dashboard/{user}', [CoachController::class, 'coachDashboard'])->name('coachDashboard');

// home
Route::get('/', [HomeController::class, 'showGame'])->name('index');

// choix jeux
Route::get('/games/{slug}', [HomeController::class, 'showGame'])->name('showGame');

// affichage coach
Route::get('/games/{game}/coaches', [HomeController::class, 'showCoaches'])->name('showCoaches');

// delete user
Route::delete('/admin/user/{id}/delete', [AdminController::class, 'destroyUser'])->name('destroyUser');
// delete coaching
Route::delete('/admin/coaching/{id}/delete', [AdminController::class, 'destroyCoaching'])->name('destroyCoaching');
// delete note
Route::delete('/admin/note/{id}/delete', [AdminController::class, 'destroyNote'])->name('destroyNote');
// delete demandes
Route::delete('/admin/demandes/{id}/delete', [AdminController::class, 'destroyDemande'])->name('destroyDemande');


// update user
Route::put('/admin/user/{id}/update', [AdminController::class, 'updateUser'])->name('updateUser');

// update role
Route::put('/users/{id}/update-role-only', [AdminController::class, 'updateRoleOnly'])->name('user.updateRoleOnly');
Route::put('/admin/coaching/{id}/update', [AdminController::class, 'updateStatusOnly'])->name('updateStatusOnly');

// show list
Route::get('/students', [AdminController::class, 'showList'])->name('student.list')->defaults('type', 'student');
Route::get('/coaches', [AdminController::class, 'showList'])->name('coach.list')->defaults('type', 'coach');
Route::get('/demandes', [AdminController::class, 'showList'])->name('demande.list')->defaults('type', 'demande');
Route::get('/coachings', [AdminController::class, 'showList'])->name('coaching.list')->defaults('type', 'coaching');

// coach Dashboard info
// update
Route::put('/admin/dashboard/{id}/update-biographie', [CoachController::class, 'updateCoachBio'])->name('updateCoachBio');
Route::put('/admin/dashboard/{id}/update-tarif', [CoachController::class, 'updateCoachTarif'])->name('updateCoachTarif');
// show
Route::get('/coach/show/demandes/{id}', [CoachController::class, 'showDemandeCoach'])->name('showDemandeCoach');

// demande accepted
Route::put('/demandes/{id}/accepted', [CoachController::class, 'demandeAccept'])->name('demandeAccept');