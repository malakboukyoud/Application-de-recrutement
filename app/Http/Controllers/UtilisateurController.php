<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur;
use App\Models\Referentiel;
use Illuminate\Support\Facades\Hash;


class UtilisateurController extends Controller
{


    /**
     * Liste des utilisateurs
     */
  public function index()
{

    $utilisateurs = Utilisateur::with('profil')
        ->paginate(10);


    return view(
        'utilisateurs.index',
        compact('utilisateurs')
    );

}



    /**
     * Formulaire création utilisateur
     */
    public function create()
    {

        $profils = Referentiel::type('profil')->get();


        return view(
            'utilisateurs.create',
            compact('profils')
        );

    }




    /**
     * Enregistrer utilisateur
     */
    public function store(Request $request)
    {


        $request->validate([

            'nom' => 'required',

            'prenom' => 'required',

            'login' => 'required|unique:utilisateurs,login',

            'email' => 'required|email|unique:utilisateurs,email',

            'mot_de_passe' => 'required|min:6',

            'id_profil' => 'required|integer',

            'actif' => 'required'

        ]);




        Utilisateur::create([


            'nom' => $request->nom,


            'prenom' => $request->prenom,


            'login' => $request->login,


            'email' => $request->email,


            'mot_de_passe' => Hash::make($request->mot_de_passe),


            'id_profil' => $request->id_profil,


            'actif' => $request->actif


        ]);




        return redirect()

            ->route('utilisateurs.index')

            ->with(
                'success',
                'Utilisateur ajouté avec succès'
            );

    }





    /**
     * Afficher utilisateur
     */
    public function show($id)
    {

        $utilisateur = Utilisateur::with('profil')
            ->findOrFail($id);


        return view(
            'utilisateurs.show',
            compact('utilisateur')
        );

    }





    /**
     * Modifier
     */
    public function edit($id)
    {

        $utilisateur = Utilisateur::findOrFail($id);


        $profils = Referentiel::type('profil')->get();


        return view(
            'utilisateurs.edit',
            compact(
                'utilisateur',
                'profils'
            )
        );

    }





    /**
     * Mise à jour
     */
    public function update(Request $request,$id)
    {


        $utilisateur = Utilisateur::findOrFail($id);



        $request->validate([

            'nom'=>'required',

            'prenom'=>'required',

            'email'=>'required|email',

            'id_profil'=>'required|integer'

        ]);




        $utilisateur->update([

            'nom'=>$request->nom,

            'prenom'=>$request->prenom,

            'email'=>$request->email,

            'id_profil'=>$request->id_profil,

            'actif'=>$request->actif

        ]);



        return redirect()

            ->route('utilisateurs.index')

            ->with(
                'success',
                'Utilisateur modifié'
            );

    }





    /**
     * Supprimer
     */
    public function destroy($id)
    {

        Utilisateur::findOrFail($id)->delete();


        return redirect()

            ->route('utilisateurs.index')

            ->with(
                'success',
                'Utilisateur supprimé'
            );

    }


}