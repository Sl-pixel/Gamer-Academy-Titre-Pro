<?php

use App\Http\Controllers\CoachController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\CoachingController;
use App\Http\Controllers\UserController; 

// Authentication routes
Route::post('/login', [AuthController::class, 'loginUser'])->name('loginUser');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'registerForm'])->name('registerForm');
Route::post('/doRegisterUser', [AuthController::class, 'registerUser'])->name('registerUser');
// logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/contact', [HomeController::class, 'contactForm'])->name('contact');
Route::get('/discord', [HomeController::class, 'discord'])->name('discord');
// home
Route::get('/', [HomeController::class, 'showGame'])->name('index');
// choix jeux
Route::get('/games/{slug}', [HomeController::class, 'showGame'])->name('showGame');
// affichage coach
Route::get('/games/{game}/coaches', [UserController::class, 'showCoaches'])->name('showCoaches');
// select coach
Route::get('/selectCoach/{id}', [UserController::class, 'selectCoach'])->name('selectCoach');
Route::get('/demande/coaching/{id}', [UserController::class, 'demanderCoaching'])->name('demanderCoaching');

Route::middleware(['auth'])->group(function () {
    // Route pour afficher le formulaire de disponibilités
    Route::get('/coach/{id}/availability', [CoachController::class, 'showAvailabilityForm'])->name('showAvailabilityForm');

    // Route pour mettre à jour les disponibilités du coach (protégée par auth)
    Route::post('/coach/{id}/availability', [CoachController::class, 'updateAvailability'])->name('updateAvailability');

    Route::get('/coach/show/demandes/{id}', [CoachController::class, 'showDemandeCoach'])->name('showDemandeCoach');
    
    // Route pour afficher les demandes d'un étudiant
    Route::get('/student/demandes/{user}', [UserController::class, 'showStudentDemandes'])->name('showStudentDemandes');
    
    // Route pour annuler une demande de coaching
    Route::delete('/demande/{id}/cancel', [UserController::class, 'cancelDemande'])->name('demande.cancel');
    
    // show list admin
    Route::get('/students', [AdminController::class, 'showList'])->name('student.list')->defaults('type', 'student');
    Route::get('/coaches', [AdminController::class, 'showList'])->name('coach.list')->defaults('type', 'coach');
    Route::get('/demandes', [AdminController::class, 'showList'])->name('demande.list')->defaults('type', 'demande');
    Route::get('/coachings', [AdminController::class, 'showList'])->name('coaching.list')->defaults('type', 'coaching');
    // Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('adminDashboard');
    Route::get('/student/dashboard/{user}', [UserController::class, 'studentDashboard'])->name('studentDashboard');
    Route::get('/coach/dashboard/{user}', [CoachController::class, 'coachDashboard'])->name('coachDashboard');   
    // fiche user
    Route::get('/admin/user/{id}/user-Info', [AdminController::class, 'showUserInfo'])->name('showUserInfo');
    Route::get('/admin/user/{id}/show-Notes', [AdminController::class, 'showNotes'])->name('showNotes');
    // show coaching and demande info
    Route::get('/admin/coaching/{id}/coaching-Info', [AdminController::class, 'showCoachingInfo'])->name('showCoachingInfo');
    Route::get('/admin/demande/{id}/demande-Info', [AdminController::class, 'showDemandeInfo'])->name('showDemandeInfo');

    Route::get('/user/demande/{id}/show', [DemandeController::class, 'showDemande'])->name('showDemande');
    Route::get('/user/coaching/{id}/show', [CoachingController::class, 'showCoaching'])->name('showCoaching');

    // edit user
    Route::get('/admin/user/{id}/edit', [AdminController::class, 'editUser'])->name('editUser');
    Route::get('/profile/user/{id}/edit', [UserController::class, 'editProfile'])->name('editProfile');
    Route::put('/admin/user/{id}/update', [AdminController::class, 'updateUser'])->name('updateUser');

    // create 
    Route::get('/create', [AdminController::class, 'create'])->name('create');
    Route::post('/create/admin', [AdminController::class, 'createAdmin'])->name('createAdmin');

    // edit demande
    Route::get('/admin/demande/{id}/edit', [AdminController::class, 'editDemande'])->name('editDemande');

    // edit coaching
    Route::get('/admin/coaching/{id}/edit', [AdminController::class, 'editCoaching'])->name('editCoaching');
    Route::get('/admin/coaching/{id}/update', [AdminController::class, 'updateCoaching'])->name('updateCoaching');   


    // delete 
    Route::delete('/admin/user/{id}/delete', [AdminController::class, 'destroyUser'])->name('destroyUser');
    Route::delete('/admin/coaching/{id}/delete', [AdminController::class, 'destroyCoaching'])->name('destroyCoaching');
    Route::delete('/admin/note/{id}/delete', [AdminController::class, 'destroyNote'])->name('destroyNote');
    Route::delete('/admin/demandes/{id}/delete', [AdminController::class, 'destroyDemande'])->name('destroyDemande');
  
    // update 
    Route::put('/users/{id}/update-role-only', [AdminController::class, 'updateRoleOnly'])->name('user.updateRoleOnly');
    Route::put('/admin/coaching/{id}/update', [AdminController::class, 'updateStatusOnly'])->name('updateStatusOnly');

    // update coach
    Route::put('/coach/dashboard/{id}/update-biographie', [CoachController::class, 'updateCoachBio'])->name('updateCoachBio');
    Route::put('/coach/dashboard/{id}/update-tarif', [CoachController::class, 'updateCoachTarif'])->name('updateCoachTarif');
    Route::put('/user/{user}/update-game', [UserController::class, 'updateGame'])->name('user.updateGame');
    
    // gestion du status des demandes
    Route::put('/demande/{id}/traiter', [CoachController::class, 'traiterDemande'])->name('demande.traiter');
});

Route::get('/404', function () {
    abort(404);
});
