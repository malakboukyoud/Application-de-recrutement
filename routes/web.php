<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OffresController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParametresController;

use App\Http\Controllers\CandidatController;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\DocumentCandidatureController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\HistoriqueActionController;
use App\Http\Controllers\ConvocationController;

/*
|--------------------------------------------------------------------------
| Authentification
|--------------------------------------------------------------------------
*/


Route::get('/', [AuthController::class, 'showLogin'])
    ->name('login.form');


Route::post('/login', [AuthController::class, 'login'])
    ->name('login');


Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register');




/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/






    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard.index');





/*
|--------------------------------------------------------------------------
| Offres
|--------------------------------------------------------------------------
*/


Route::resource('offres', OffresController::class);





/*
|--------------------------------------------------------------------------
| Utilisateurs
|--------------------------------------------------------------------------
*/


Route::resource('utilisateurs', UtilisateurController::class);



Route::put('/utilisateurs/{id}/activer',
    [UtilisateurController::class,'activer'])
    ->name('utilisateurs.activer');



Route::put('/utilisateurs/{id}/desactiver',
    [UtilisateurController::class,'desactiver'])
    ->name('utilisateurs.desactiver');

    


Route::get('/parametres', [ParametresController::class, 'index'])
    ->name('parametres.index');


// À insérer dans routes/web.php de votre projet Laravel.
// Ajoutez ->middleware(['auth']) (et une policy par profil) selon §11 du cahier des charges.
Route::resource('candidats', CandidatController::class);



Route::resource('candidatures', CandidatureController::class);
Route::patch('candidatures/{candidature}/etat', [CandidatureController::class, 'changerEtat'])
    ->name('candidatures.changer-etat');

Route::post('candidatures/{candidature}/documents', [DocumentCandidatureController::class, 'store'])
    ->name('candidatures.documents.store');
Route::delete('candidatures/{candidature}/documents/{document}', [DocumentCandidatureController::class, 'destroy'])
    ->name('candidatures.documents.destroy');
Route::get('candidatures/{candidature}/documents/{document}/telecharger', [DocumentCandidatureController::class, 'download'])
    ->name('candidatures.documents.download');



// Évaluations — rattachées à une candidature (§6.7)
Route::get('candidatures/{candidature}/evaluations/create', [EvaluationController::class, 'create'])
    ->name('candidatures.evaluations.create');
Route::post('candidatures/{candidature}/evaluations', [EvaluationController::class, 'store'])
    ->name('candidatures.evaluations.store');
Route::get('evaluations/{evaluation}/edit', [EvaluationController::class, 'edit'])
    ->name('evaluations.edit');
Route::put('evaluations/{evaluation}', [EvaluationController::class, 'update'])
    ->name('evaluations.update');
Route::delete('evaluations/{evaluation}', [EvaluationController::class, 'destroy'])
    ->name('evaluations.destroy');




// Historique des actions — journal d'audit (§12)
Route::get('historique', [HistoriqueActionController::class, 'index'])->name('historique.index');


Route::get('/dashboard/export/excel', [DashboardController::class, 'exportExcel'])
    ->name('dashboard.export.excel');

Route::get('/dashboard/export/pdf', [DashboardController::class, 'exportPdf'])
    ->name('dashboard.export.pdf');


Route::get('/test-gd', function () {
    return extension_loaded('gd') ? 'GD OK' : 'GD ABSENT';
});

Route::get('/php-test', function () {

    return [
        'php_ini' => php_ini_loaded_file(),
        'extension_dir' => ini_get('extension_dir'),
        'gd_loaded' => extension_loaded('gd'),
        'gd_info' => function_exists('gd_info'),
        'loaded_extensions' => get_loaded_extensions(),
    ];

});
Route::resource('convocations', ConvocationController::class);