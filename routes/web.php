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
use App\Http\Controllers\AdmisController;

/*
|--------------------------------------------------------------------------
| Profils utilisés (§11 du cahier des charges) :
|   Administrateur, RH, Commission,
|   Responsable de service, Consultation.
| L'Administrateur a toujours accès à tout (voir CheckProfil::handle()).
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Authentification (routes publiques, sans middleware)
|--------------------------------------------------------------------------
*/

Route::get('/', [AuthController::class, 'showLogin'])
    ->name('login.form');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// Réservé à l'Administrateur : la création de comptes ne doit pas être
// publique (§11 : "Gérer les comptes utilisateurs" est un droit Administrateur).
Route::post('/register', [AuthController::class, 'register'])
    ->name('register')
    ->middleware(['auth.session', 'profil:Administrateur']);

/*
|--------------------------------------------------------------------------
| Tout ce qui suit nécessite d'être connecté
|--------------------------------------------------------------------------
*/
Route::middleware('auth.session')->group(function () {

    /*
    |----------------------------------------------------------------------
    | Dashboard — accessible à tous les profils connectés
    |----------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard.index');

    // Exports : Administrateur, RH, Responsable de service
    Route::get('/dashboard/export/excel', [DashboardController::class, 'exportExcel'])
        ->name('dashboard.export.excel')
        ->middleware('profil:RH,Responsable de service');

    Route::get('/dashboard/export/pdf', [DashboardController::class, 'exportPdf'])
        ->name('dashboard.export.pdf')
        ->middleware('profil:RH,Responsable de service');

    /*
    |----------------------------------------------------------------------
    | Offres — consultation ouverte à tous, gestion réservée au RH
    |----------------------------------------------------------------------
    */
    Route::middleware('profil:RH')->group(function () {
        Route::get('offres/create', [OffresController::class, 'create'])->name('offres.create');
        Route::post('offres', [OffresController::class, 'store'])->name('offres.store');
        Route::get('offres/{offre}/edit', [OffresController::class, 'edit'])->name('offres.edit');
        Route::put('offres/{offre}', [OffresController::class, 'update'])->name('offres.update');
        Route::patch('offres/{offre}', [OffresController::class, 'update']);
        Route::delete('offres/{offre}', [OffresController::class, 'destroy'])->name('offres.destroy');
    });
    Route::get('offres', [OffresController::class, 'index'])->name('offres.index');
    Route::get('offres/{offre}', [OffresController::class, 'show'])->name('offres.show');

    /*
    |----------------------------------------------------------------------
    | Utilisateurs — Administrateur uniquement (§11)
    |----------------------------------------------------------------------
    */
    Route::resource('utilisateurs', UtilisateurController::class)
        ->middleware('profil:Administrateur');

    Route::put('/utilisateurs/{id}/activer', [UtilisateurController::class, 'activer'])
        ->name('utilisateurs.activer')
        ->middleware('profil:Administrateur');

    Route::put('/utilisateurs/{id}/desactiver', [UtilisateurController::class, 'desactiver'])
        ->name('utilisateurs.desactiver')
        ->middleware('profil:Administrateur');

    /*
    |----------------------------------------------------------------------
    | Paramètres / référentiels — Administrateur uniquement (§11)
    |----------------------------------------------------------------------
    */
    Route::middleware('profil:Administrateur')->group(function () {
        Route::get('parametres', [ParametreController::class, 'index'])->name('parametres.index');
        Route::put('parametres/profil', [ParametreController::class, 'updateProfil'])->name('parametres.profil.update');
        Route::post('parametres/referentiels', [ParametreController::class, 'storeReferentiel'])->name('parametres.referentiels.store');
        Route::patch('parametres/referentiels/{referentiel}/toggle', [ParametreController::class, 'toggleReferentiel'])->name('parametres.referentiels.toggle');
        Route::put('parametres/organisme', [ParametreController::class, 'updateOrganisme'])->name('parametres.organisme.update');
        Route::post('parametres/preferences', [ParametreController::class, 'updatePreferences'])->name('parametres.preferences.update');
    });

    /*
    |----------------------------------------------------------------------
    | Candidats — consultation ouverte (données sensibles masquées en vue
    | pour les profils non autorisés, voir Utilisateur::peutVoirDonneesPersonnelles),
    | gestion réservée au RH
    |----------------------------------------------------------------------
    */
    Route::middleware('profil:RH')->group(function () {
        Route::get('candidats/create', [CandidatController::class, 'create'])->name('candidats.create');
        Route::post('candidats', [CandidatController::class, 'store'])->name('candidats.store');
        Route::get('candidats/{candidat}/edit', [CandidatController::class, 'edit'])->name('candidats.edit');
        Route::put('candidats/{candidat}', [CandidatController::class, 'update'])->name('candidats.update');
        Route::patch('candidats/{candidat}', [CandidatController::class, 'update']);
        Route::delete('candidats/{candidat}', [CandidatController::class, 'destroy'])->name('candidats.destroy');
    });
    Route::get('candidats', [CandidatController::class, 'index'])->name('candidats.index');
    Route::get('candidats/{candidat}', [CandidatController::class, 'show'])->name('candidats.show');

    /*
    |----------------------------------------------------------------------
    | Candidatures — consultation ouverte, gestion réservée au RH
    |----------------------------------------------------------------------
    */
    Route::middleware('profil:RH')->group(function () {
        Route::get('candidatures/create', [CandidatureController::class, 'create'])->name('candidatures.create');
        Route::post('candidatures', [CandidatureController::class, 'store'])->name('candidatures.store');
        Route::get('candidatures/{candidature}/edit', [CandidatureController::class, 'edit'])->name('candidatures.edit');
        Route::put('candidatures/{candidature}', [CandidatureController::class, 'update'])->name('candidatures.update');
        Route::patch('candidatures/{candidature}', [CandidatureController::class, 'update']);
        Route::delete('candidatures/{candidature}', [CandidatureController::class, 'destroy'])->name('candidatures.destroy');

        Route::patch('candidatures/{candidature}/etat', [CandidatureController::class, 'changerEtat'])
            ->name('candidatures.changer-etat');

        Route::post('candidatures/{candidature}/documents', [DocumentCandidatureController::class, 'store'])
            ->name('candidatures.documents.store');
        Route::delete('candidatures/{candidature}/documents/{document}', [DocumentCandidatureController::class, 'destroy'])
            ->name('candidatures.documents.destroy');
    });
    // Résultats des candidatures admises : formulaire de saisie (RH/Commission),
    // liste triée par classement et exports Excel/PDF (mêmes droits que "Résultats" / admis.index).
    Route::middleware('profil:RH,Commission')->group(function () {
        Route::get('candidatures/{candidature}/resultats', [CandidatureController::class, 'editResultats'])
            ->name('candidatures.resultats.edit');
        Route::put('candidatures/{candidature}/resultats', [CandidatureController::class, 'updateResultats'])
            ->name('candidatures.resultats.update');

        Route::get('candidatures/resultats/admis', [CandidatureController::class, 'resultatsAdmis'])
            ->name('candidatures.resultats.admis');
        Route::get('candidatures/resultats/export/excel', [CandidatureController::class, 'exportResultatsExcel'])
            ->name('candidatures.resultats.export.excel');
        Route::get('candidatures/resultats/export/pdf', [CandidatureController::class, 'exportResultatsPdf'])
            ->name('candidatures.resultats.export.pdf');
    });

    Route::get('candidatures', [CandidatureController::class, 'index'])->name('candidatures.index');
    Route::get('candidatures/{candidature}', [CandidatureController::class, 'show'])->name('candidatures.show');

    // Téléchargement d'un document : consultation possible pour RH,
    // Commission (examen du dossier) et Responsable de service (avis technique).
    Route::get('candidatures/{candidature}/documents/{document}/telecharger', [DocumentCandidatureController::class, 'download'])
        ->name('candidatures.documents.download')
        ->middleware('profil:RH,Commission,Responsable de service');

    Route::get('documents', [DocumentCandidatureController::class, 'index'])
        ->name('documents.index')
        ->middleware('profil:RH,Commission');

    /*
    |----------------------------------------------------------------------
    | Évaluations — saisie des notes/avis réservée à la Commission de
    | recrutement (§11 : "saisir avis, notes, classement et résultats"),
    | consultation élargie à RH et Responsable de service
    |----------------------------------------------------------------------
    */
    Route::middleware('profil:Commission')->group(function () {
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
    });
    Route::get('evaluations', [EvaluationController::class, 'index'])
        ->name('evaluations.index')
        ->middleware('profil:RH,Commission,Responsable de service');

    /*
    |----------------------------------------------------------------------
    | Convocations — gestion réservée au RH, consultation élargie
    |----------------------------------------------------------------------
    */
    Route::middleware('profil:RH')->group(function () {
        Route::get('convocations/create', [ConvocationController::class, 'create'])->name('convocations.create');
        Route::post('convocations', [ConvocationController::class, 'store'])->name('convocations.store');
        Route::get('convocations/{convocation}/edit', [ConvocationController::class, 'edit'])->name('convocations.edit');
        Route::put('convocations/{convocation}', [ConvocationController::class, 'update'])->name('convocations.update');
        Route::patch('convocations/{convocation}', [ConvocationController::class, 'update']);
        Route::delete('convocations/{convocation}', [ConvocationController::class, 'destroy'])->name('convocations.destroy');
    });

    // Exports (Excel / PDF) de la liste des convocations — mêmes filtres que la page,
    // mêmes droits d'accès que la consultation. Déclarés avant la route {convocation}
    // ci-dessous pour que "export" ne soit pas interprété comme un identifiant.
    Route::get('convocations/export/excel', [ConvocationController::class, 'exportExcel'])
        ->name('convocations.export.excel')
        ->middleware('profil:RH,Commission');
    Route::get('convocations/export/pdf', [ConvocationController::class, 'exportPdf'])
        ->name('convocations.export.pdf')
        ->middleware('profil:RH,Commission');

    Route::get('convocations', [ConvocationController::class, 'index'])
        ->name('convocations.index')
        ->middleware('profil:RH,Commission');
    Route::get('convocations/{convocation}', [ConvocationController::class, 'show'])
        ->name('convocations.show')
        ->middleware('profil:RH,Commission');

    /*
    |----------------------------------------------------------------------
    | Résultats / admis — RH et Commission (validation résultats)
    |----------------------------------------------------------------------
    */
    Route::get('/admis', [AdmisController::class, 'index'])
        ->name('admis.index')
        ->middleware('profil:RH,Commission');

    /*
    |----------------------------------------------------------------------
    | Historique / journal d'audit — Administrateur uniquement (§12)
    |----------------------------------------------------------------------
    */
    Route::get('historique', [HistoriqueActionController::class, 'index'])
        ->name('historique.index')
        ->middleware('profil:Administrateur');

    /*
    |----------------------------------------------------------------------
    | Outils de debug — à retirer avant mise en production
    |----------------------------------------------------------------------
    */
    Route::middleware('profil:Administrateur')->group(function () {
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
    });
});