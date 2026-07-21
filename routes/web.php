<?php

use App\Http\Controllers\CandidatController;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\DocumentCandidatureController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\HistoriqueActionController;
use Illuminate\Support\Facades\Route;

// À insérer dans routes/web.php de votre projet Laravel.
// Ajoutez ->middleware(['auth']) (et une policy par profil) selon §11 du cahier des charges.

Route::redirect('/', '/candidatures');

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
