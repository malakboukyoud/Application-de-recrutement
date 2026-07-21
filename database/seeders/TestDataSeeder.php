<?php

namespace Database\Seeders;

use App\Models\Candidat;
use App\Models\Candidature;
use App\Models\Convocation;
use App\Models\Evaluation;
use App\Models\OffreRecrutement;
use App\Models\Referentiel;
use App\Models\Utilisateur;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Jeu de données de démonstration pour tester les pages Candidats,
     * Candidatures, Évaluations et Historique. À exécuter après UtilisateurSeeder :
     *   php artisan db:seed --class=UtilisateurSeeder
     *   php artisan db:seed --class=TestDataSeeder
     */
    public function run(): void
    {
        $admin = Utilisateur::first();

        if (! $admin) {
            $this->command->error('Aucun utilisateur trouvé. Lancez d\'abord : php artisan db:seed --class=UtilisateurSeeder');

            return;
        }

        // ------------------------------------------------------------
        // Référentiels (diplômes / spécialités)
        // ------------------------------------------------------------
        $diplomeIngenieur = Referentiel::firstOrCreate(['type_ref' => 'diplome', 'libelle' => "Diplôme d'ingénieur d'État"]);
        $diplomeTechnicien = Referentiel::firstOrCreate(['type_ref' => 'diplome', 'libelle' => 'Diplôme de technicien spécialisé']);
        $diplomeLicence = Referentiel::firstOrCreate(['type_ref' => 'diplome', 'libelle' => 'Licence']);

        $specAgronomie = Referentiel::firstOrCreate(['type_ref' => 'specialite', 'libelle' => 'Génie rural / Agronomie']);
        $specInformatique = Referentiel::firstOrCreate(['type_ref' => 'specialite', 'libelle' => 'Informatique et systèmes']);
        $specComptabilite = Referentiel::firstOrCreate(['type_ref' => 'specialite', 'libelle' => 'Comptabilité et gestion']);

        // ------------------------------------------------------------
        // Offres de recrutement
        // ------------------------------------------------------------
        $offreIngenieur = OffreRecrutement::firstOrCreate(
            ['reference_offre' => 'ORMVASM-2026-001'],
            [
                'intitule_poste' => 'Ingénieur en génie rural',
                'type_recrutement' => 'concours',
                'nombre_postes' => 2,
                'service_concerne' => "Direction des aménagements hydro-agricoles",
                'lieu_affectation' => 'Taroudant',
                'id_diplome_exige' => $diplomeIngenieur->id_ref,
                'id_specialite_exigee' => $specAgronomie->id_ref,
                'experience_exigee' => '2 ans minimum',
                'date_publication' => now()->subDays(30),
                'date_limite_depot' => now()->subDays(5),
                'statut' => 'en_traitement',
                'description_poste' => "Conception et suivi des projets d'irrigation et d'aménagement hydro-agricole.",
                'conditions_participation' => 'Nationalité marocaine, âge maximum 40 ans.',
                'pieces_exigees' => 'cv,lettre_motivation,cin,diplome,releve_notes',
                'id_createur' => $admin->id_utilisateur,
            ]
        );

        $offreTechnicien = OffreRecrutement::firstOrCreate(
            ['reference_offre' => 'ORMVASM-2026-002'],
            [
                'intitule_poste' => 'Technicien spécialisé en irrigation',
                'type_recrutement' => 'contractuel',
                'nombre_postes' => 3,
                'service_concerne' => 'Service exploitation et maintenance',
                'lieu_affectation' => 'Agadir',
                'id_diplome_exige' => $diplomeTechnicien->id_ref,
                'id_specialite_exigee' => $specAgronomie->id_ref,
                'experience_exigee' => '1 an',
                'date_publication' => now()->subDays(20),
                'date_limite_depot' => now()->addDays(10),
                'statut' => 'publiee',
                'description_poste' => "Maintenance des réseaux d'irrigation et suivi technique sur le terrain.",
                'pieces_exigees' => 'cv,lettre_motivation,cin,diplome',
                'id_createur' => $admin->id_utilisateur,
            ]
        );

        $offreInformaticien = OffreRecrutement::firstOrCreate(
            ['reference_offre' => 'ORMVASM-2026-003'],
            [
                'intitule_poste' => 'Développeur / Administrateur systèmes',
                'type_recrutement' => 'contractuel',
                'nombre_postes' => 1,
                'service_concerne' => "Division des systèmes d'information",
                'lieu_affectation' => 'Agadir - Siège',
                'id_diplome_exige' => $diplomeLicence->id_ref,
                'id_specialite_exigee' => $specInformatique->id_ref,
                'experience_exigee' => '3 ans',
                'date_publication' => now()->subDays(15),
                'date_limite_depot' => now()->addDays(15),
                'statut' => 'publiee',
                'description_poste' => "Développement et maintenance des applications métier de l'office.",
                'pieces_exigees' => 'cv,lettre_motivation,cin,diplome,attestation_travail',
                'id_createur' => $admin->id_utilisateur,
            ]
        );

        // ------------------------------------------------------------
        // Candidats
        // ------------------------------------------------------------
        $candidats = [
            ['nom' => 'Alaoui', 'prenom' => 'Yassine', 'cin' => 'JC10234', 'sexe' => 'M', 'ville' => 'Agadir', 'diplome' => "Diplôme d'ingénieur d'État", 'specialite' => 'Génie rural', 'niveau_etude' => 'Bac+5', 'etablissement' => 'IAV Hassan II', 'annee_obtention' => 2022, 'telephone' => '0612345678', 'email' => 'y.alaoui@example.com'],
            ['nom' => 'Bennani', 'prenom' => 'Salma', 'cin' => 'JB55219', 'sexe' => 'F', 'ville' => 'Taroudant', 'diplome' => "Diplôme d'ingénieur d'État", 'specialite' => 'Agronomie', 'niveau_etude' => 'Bac+5', 'etablissement' => 'ENA Meknès', 'annee_obtention' => 2021, 'telephone' => '0623456789', 'email' => 's.bennani@example.com'],
            ['nom' => 'El Amrani', 'prenom' => 'Karim', 'cin' => 'JE98771', 'sexe' => 'M', 'ville' => 'Agadir', 'diplome' => 'Diplôme de technicien spécialisé', 'specialite' => 'Irrigation', 'niveau_etude' => 'Bac+2', 'etablissement' => 'ISTA Agadir', 'annee_obtention' => 2023, 'telephone' => '0634567890', 'email' => 'k.elamrani@example.com'],
            ['nom' => 'Idrissi', 'prenom' => 'Fatima', 'cin' => 'JD44102', 'sexe' => 'F', 'ville' => 'Inezgane', 'diplome' => 'Diplôme de technicien spécialisé', 'specialite' => 'Irrigation', 'niveau_etude' => 'Bac+2', 'etablissement' => 'ISTA Inezgane', 'annee_obtention' => 2022, 'telephone' => '0645678901', 'email' => 'f.idrissi@example.com'],
            ['nom' => 'Tazi', 'prenom' => 'Omar', 'cin' => 'JF30987', 'sexe' => 'M', 'ville' => 'Agadir', 'diplome' => 'Licence', 'specialite' => 'Informatique', 'niveau_etude' => 'Bac+3', 'etablissement' => 'FST Agadir', 'annee_obtention' => 2020, 'telephone' => '0656789012', 'email' => 'o.tazi@example.com', 'experience' => "3 ans en tant que développeur web dans une société privée."],
            ['nom' => 'Chraibi', 'prenom' => 'Nadia', 'cin' => 'JG20456', 'sexe' => 'F', 'ville' => 'Taroudant', 'diplome' => "Diplôme d'ingénieur d'État", 'specialite' => 'Génie rural', 'niveau_etude' => 'Bac+5', 'etablissement' => 'ENAM', 'annee_obtention' => 2023, 'telephone' => '0667890123', 'email' => 'n.chraibi@example.com'],
            ['nom' => 'Ouazzani', 'prenom' => 'Hamza', 'cin' => 'JH11223', 'sexe' => 'M', 'ville' => 'Ait Melloul', 'diplome' => 'Diplôme de technicien spécialisé', 'specialite' => 'Irrigation', 'niveau_etude' => 'Bac+2', 'etablissement' => 'ISTA Agadir', 'annee_obtention' => 2021, 'telephone' => '0678901234', 'email' => 'h.ouazzani@example.com'],
            ['nom' => 'Fassi', 'prenom' => 'Imane', 'cin' => 'JI33445', 'sexe' => 'F', 'ville' => 'Agadir', 'diplome' => 'Licence', 'specialite' => 'Informatique', 'niveau_etude' => 'Bac+3', 'etablissement' => 'ENSA Agadir', 'annee_obtention' => 2024, 'telephone' => '0689012345', 'email' => 'i.fassi@example.com'],
        ];

        $candidatsCrees = collect($candidats)->map(
            fn ($c) => Candidat::firstOrCreate(['cin' => $c['cin']], $c)
        );

        // ------------------------------------------------------------
        // Candidatures — plusieurs états pour tester tous les filtres
        // ------------------------------------------------------------
        $candidatures = [
            // Ingénieur génie rural
            ['candidat' => 0, 'offre' => $offreIngenieur, 'etat' => 'admise', 'dossier_complet' => true, 'decision_finale' => 'admis', 'classement' => 1],
            ['candidat' => 1, 'offre' => $offreIngenieur, 'etat' => 'liste_attente', 'dossier_complet' => true, 'decision_finale' => 'liste_attente', 'classement' => 2],
            ['candidat' => 5, 'offre' => $offreIngenieur, 'etat' => 'rejetee', 'dossier_complet' => true, 'motif' => 'Diplôme non conforme à la spécialité exigée.'],

            // Technicien irrigation
            ['candidat' => 2, 'offre' => $offreTechnicien, 'etat' => 'preselectionnee', 'dossier_complet' => true],
            ['candidat' => 3, 'offre' => $offreTechnicien, 'etat' => 'convoquee', 'dossier_complet' => true],
            ['candidat' => 6, 'offre' => $offreTechnicien, 'etat' => 'incomplete', 'dossier_complet' => false],

            // Développeur
            ['candidat' => 4, 'offre' => $offreInformaticien, 'etat' => 'en_etude', 'dossier_complet' => true],
            ['candidat' => 7, 'offre' => $offreInformaticien, 'etat' => 'recue', 'dossier_complet' => false],
        ];

        $candidaturesCreees = [];

        foreach ($candidatures as $i => $data) {
            $candidat = $candidatsCrees[$data['candidat']];

            $candidature = Candidature::firstOrCreate(
                ['id_candidat' => $candidat->id_candidat, 'id_offre' => $data['offre']->id_offre],
                [
                    'date_depot' => now()->subDays(rand(3, 25)),
                    'mode_depot' => collect(['plateforme', 'email', 'papier'])->random(),
                    'etat_candidature' => $data['etat'],
                    'dossier_complet' => $data['dossier_complet'],
                    'motif_rejet' => $data['motif'] ?? null,
                    'classement' => $data['classement'] ?? null,
                    'decision_finale' => $data['decision_finale'] ?? null,
                    'observation_rh' => 'Dossier traité dans le cadre de la campagne de recrutement 2026.',
                ]
            );

            $candidaturesCreees[$i] = $candidature;
        }

        // ------------------------------------------------------------
        // Convocation + évaluation d'exemple sur la candidature "convoquée"
        // ------------------------------------------------------------
        $candidatureConvoquee = $candidaturesCreees[4];

        $convocation = Convocation::firstOrCreate(
            ['id_candidature' => $candidatureConvoquee->id_candidature, 'type_convocation' => 'entretien_oral'],
            [
                'date_convocation' => now()->addDays(5),
                'heure_convocation' => '09:00',
                'lieu_convocation' => "Siège de l'ORMVASM - Agadir",
                'statut_presence' => 'convoque',
            ]
        );

        // Évaluation sur la candidature déjà admise, pour illustrer la note finale calculée
        $candidatureAdmise = $candidaturesCreees[0];

        Evaluation::firstOrCreate(
            ['id_candidature' => $candidatureAdmise->id_candidature],
            [
                'note_ecrite' => 15.5,
                'note_orale' => 17,
                'note_pratique' => 14,
                'coefficient_ecrit' => 2,
                'coefficient_oral' => 1,
                'coefficient_pratique' => 1,
                'appreciation' => 'Très bon candidat, solide maîtrise technique.',
                'saisi_par' => $admin->id_utilisateur,
            ]
        );

        $this->command->info('Données de test créées : 3 offres, ' . count($candidats) . ' candidats, ' . count($candidatures) . ' candidatures.');
    }
}
