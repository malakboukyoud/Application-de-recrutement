<?php

namespace App\Http\Controllers;

use App\Models\HistoriqueAction;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HistoriqueActionController extends Controller
{
    /**
     * Journal d'audit — traçabilité de toutes les actions (§12 du cahier des charges) :
     * qui a fait quoi, quand, sur quel enregistrement. Filtrable par table concernée,
     * par utilisateur et par période.
     */
    public function index(Request $request): View
    {
        $filtres = array_merge(
            ['table_concernee' => null, 'id_utilisateur' => null, 'date_debut' => null, 'date_fin' => null],
            $request->only(['table_concernee', 'id_utilisateur', 'date_debut', 'date_fin'])
        );

        $historique = HistoriqueAction::query()
            ->with('utilisateur')
            ->when($filtres['table_concernee'], fn ($q, $v) => $q->where('table_concernee', $v))
            ->when($filtres['id_utilisateur'], fn ($q, $v) => $q->where('id_utilisateur', $v))
            ->when($filtres['date_debut'], fn ($q, $v) => $q->whereDate('date_action', '>=', $v))
            ->when($filtres['date_fin'], fn ($q, $v) => $q->whereDate('date_action', '<=', $v))
            ->orderByDesc('date_action')
            ->paginate(25)
            ->withQueryString();

        // Liste des tables distinctes réellement journalisées, pour peupler le filtre
        $tables = HistoriqueAction::query()->distinct()->orderBy('table_concernee')->pluck('table_concernee');
        $utilisateurs = Utilisateur::orderBy('nom')->get(['id_utilisateur', 'nom', 'prenom']);

        return view('historique.index', compact('historique', 'tables', 'utilisateurs', 'filtres'));
    }
}
