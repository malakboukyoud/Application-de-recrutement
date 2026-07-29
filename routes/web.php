<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OffresController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParametreController;

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


Route::resource('offres', OffresController::class)->only(['index', 'show']);

Route::middleware('role:administrateur,rh')->group(function () {
    Route::resource('offres', OffresController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
});





/*
|--------------------------------------------------------------------------
| Utilisateurs
|--------------------------------------------------------------------------
*/


// Gestion des comptes utilisateurs : réservée à l'administrateur uniquement.
// (Chaque utilisateur gère ses propres informations depuis /parametres, voir plus bas.)
Route::middleware('role:administrateur')->group(function () {
    Route::resource('utilisateurs', UtilisateurController::class);

    Route::put('/utilisateurs/{id}/activer',
        [UtilisateurController::class,'activer'])
        ->name('utilisateurs.activer');

    Route::put('/utilisateurs/{id}/desactiver',
        [UtilisateurController::class,'desactiver'])
        ->name('utilisateurs.desactiver');
});

    


Route::get('parametres', [ParametreController::class, 'index'])->name('parametres.index');
Route::post('parametres/referentiels', [ParametreController::class, 'storeReferentiel'])->name('parametres.referentiels.store');
Route::patch('parametres/referentiels/{referentiel}/toggle', [ParametreController::class, 'toggleReferentiel'])->name('parametres.referentiels.toggle');
Route::put('parametres/organisme', [ParametreController::class, 'updateOrganisme'])->name('parametres.organisme.update');
Route::post('parametres/preferences', [ParametreController::class, 'updatePreferences'])->name('parametres.preferences.update');

// Chaque utilisateur connecté peut modifier ses propres informations (nom, email, mot de passe).
Route::put('parametres/profil', [ParametreController::class, 'updateProfil'])->name('parametres.profil.update');


/*
|--------------------------------------------------------------------------
| Candidats / Candidatures / Documents / Évaluations
|--------------------------------------------------------------------------
| Règle d'accès (§11 du cahier des charges) :
|   - Admin et RH : création / modification / suppression sans restriction.
|   - Commission  : consultation des candidatures + saisie des avis, notes,
|                    classement et résultats uniquement (aucune création,
|                    modification ou suppression en dehors de ce périmètre).
*/

// Candidats : lecture ouverte à tout utilisateur connecté (y compris Commission),
// création/modification/suppression réservées Admin + RH.
Route::resource('candidats', CandidatController::class)->only(['index', 'show']);
Route::middleware('role:administrateur,rh')->group(function () {
    Route::resource('candidats', CandidatController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
});

// ---------- Consultation (routes littérales) : Admin, RH, Commission ----------
Route::middleware('role:administrateur,rh,commission')->group(function () {
    Route::get('candidatures', [CandidatureController::class, 'index'])->name('candidatures.index');
    Route::get('documents', [DocumentCandidatureController::class, 'index'])->name('documents.index');
    Route::get('evaluations', [EvaluationController::class, 'index'])->name('evaluations.index');
});

// ---------- Création : Admin, RH uniquement ----------
// IMPORTANT : les routes littérales ('create') doivent être déclarées AVANT les routes
// avec un paramètre ('{candidature}') pour éviter que Laravel ne capture "create" comme
// étant un id de candidature (conflit d'ordre de routage classique).
Route::middleware('role:administrateur,rh')->group(function () {
    Route::get('candidatures/create', [CandidatureController::class, 'create'])->name('candidatures.create');
    Route::post('candidatures', [CandidatureController::class, 'store'])->name('candidatures.store');
});

// ---------- Consultation (routes avec paramètre) : Admin, RH, Commission ----------
Route::middleware('role:administrateur,rh,commission')->group(function () {
    Route::get('candidatures/{candidature}', [CandidatureController::class, 'show'])->name('candidatures.show');

    Route::get('candidatures/{candidature}/documents/{document}/telecharger', [DocumentCandidatureController::class, 'download'])
        ->name('candidatures.documents.download');
});

// ---------- Modification / suppression : Admin, RH uniquement ----------
Route::middleware('role:administrateur,rh')->group(function () {
    Route::get('candidatures/{candidature}/edit', [CandidatureController::class, 'edit'])->name('candidatures.edit');
    Route::put('candidatures/{candidature}', [CandidatureController::class, 'update'])->name('candidatures.update');
    Route::delete('candidatures/{candidature}', [CandidatureController::class, 'destroy'])->name('candidatures.destroy');

    Route::patch('candidatures/{candidature}/etat', [CandidatureController::class, 'changerEtat'])
        ->name('candidatures.changer-etat');

    Route::post('candidatures/{candidature}/documents', [DocumentCandidatureController::class, 'store'])
        ->name('candidatures.documents.store');
    Route::delete('candidatures/{candidature}/documents/{document}', [DocumentCandidatureController::class, 'destroy'])
        ->name('candidatures.documents.destroy');
});

// ---------- Avis / notes / classement / résultats : Admin, RH, Commission ----------
Route::middleware('role:administrateur,rh,commission')->group(function () {
    Route::get('candidatures/{candidature}/evaluations/create', [EvaluationController::class, 'create'])
        ->name('candidatures.evaluations.create');
    Route::post('candidatures/{candidature}/evaluations', [EvaluationController::class, 'store'])
        ->name('candidatures.evaluations.store');
    Route::get('evaluations/{evaluation}/edit', [EvaluationController::class, 'edit'])
        ->name('evaluations.edit');
    Route::put('evaluations/{evaluation}', [EvaluationController::class, 'update'])
        ->name('evaluations.update');

    // Classement / décision finale / avis commission uniquement — les autres champs
    // de la candidature (candidat, offre, dossier, état...) restent Admin/RH.
    Route::get('candidatures/{candidature}/resultats', [CandidatureController::class, 'editResultats'])
        ->name('candidatures.resultats.edit');
    Route::put('candidatures/{candidature}/resultats', [CandidatureController::class, 'updateResultats'])
        ->name('candidatures.resultats.update');
});

// ---------- Résultats : liste des candidats admis (Admin, RH, Commission) ----------
Route::middleware('role:administrateur,rh,commission')->group(function () {
    Route::get('resultats', [CandidatureController::class, 'resultatsAdmis'])->name('resultats.index');
    Route::get('resultats/export/excel', [CandidatureController::class, 'exportResultatsExcel'])->name('resultats.export.excel');
    Route::get('resultats/export/pdf', [CandidatureController::class, 'exportResultatsPdf'])->name('resultats.export.pdf');
});

// ---------- Suppression évaluation : Admin, RH uniquement ----------
Route::middleware('role:administrateur,rh')->group(function () {
    Route::delete('evaluations/{evaluation}', [EvaluationController::class, 'destroy'])->name('evaluations.destroy');
});




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
// Convocations : consultation ouverte à tout utilisateur connecté (Commission incluse),
// création/modification/suppression réservées Admin + RH.
Route::resource('convocations', ConvocationController::class)->only(['index', 'show']);
Route::middleware('role:administrateur,rh')->group(function () {
    Route::resource('convocations', ConvocationController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
});

// Export de la liste des candidats convoqués (mêmes filtres que la page) — accessible
// à tous ceux qui peuvent consulter les convocations (Admin, RH, Commission).
Route::get('convocations/export/excel', [ConvocationController::class, 'exportExcel'])->name('convocations.export.excel');
Route::get('convocations/export/pdf', [ConvocationController::class, 'exportPdf'])->name('convocations.export.pdf');