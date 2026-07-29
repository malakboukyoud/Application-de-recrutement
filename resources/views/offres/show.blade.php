<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Détails de l'offre | ORMVASM</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

:root{

    --orange:#F97316;
    --blue:#2563EB;
    --green:#16A34A;
    --red:#DC2626;
    --light:#F5F7F6;
    --bg:#F5F7FA;
    --white:#FFFFFF;
    --border:#E5E7EB;
    --text:#1F2937;
    --gray:#6B7280;

}

*{

    margin:0;
    padding:0;
    box-sizing:border-box;

}

/* Liens : professionnels, jamais soulignes ni bleus, meme visites */
a, a:visited, a:hover, a:active{
    color:inherit;
    text-decoration:none;
}


body{

    background:var(--light);
    font-family:"Segoe UI",sans-serif;
    color:var(--text);

}

.container-page{

    max-width:1100px;
    margin:45px auto;
    padding:20px;

}

.offer-card{

    background:white;

    border-radius:18px;

    box-shadow:0 10px 35px rgba(0,0,0,.08);

    overflow:hidden;

}

.card-header{

    padding:30px 35px;

    border-bottom:1px solid var(--border);

    display:flex;

    justify-content:space-between;

    align-items:center;

    flex-wrap:wrap;

    gap:20px;

}

.title h2{

    font-size:30px;

    margin-bottom:8px;

}

.title p{

    color:var(--gray);

    margin:0;

}

.badge-status{

    padding:10px 20px;

    border-radius:30px;

    font-size:14px;

    font-weight:600;

}

.open{

    background:#DCFCE7;

    color:#166534;

}

.close{

    background:#FEE2E2;

    color:#991B1B;

}

.card-body{

    padding:35px;

}

.section-title{

    font-size:20px;

    font-weight:700;

    margin-bottom:25px;

    color:#111827;

}

.info-grid{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:20px;

}

.info-box{

    background:#FAFAFA;

    border:1px solid #ECECEC;

    border-radius:12px;

    padding:18px;

}

.info-box label{

    display:block;

    color:#6B7280;

    font-size:13px;

    margin-bottom:8px;

    font-weight:600;

}

.info-box span{

    font-size:16px;

    font-weight:600;

    color:#1F2937;

}

.text-card{

    margin-top:30px;

    border:1px solid #ECECEC;

    border-radius:12px;

    padding:22px;

    background:#FCFCFC;

}

.text-card h5{

    margin-bottom:15px;

    color:#111827;

}

.text-card p{

    margin:0;

    line-height:1.8;

    color:#4B5563;

    white-space:pre-line;

}

.buttons{

    margin-top:35px;

    display:flex;

    justify-content:flex-end;

    gap:15px;

}

.btn-return{

    background:#F3F4F6;

    color:#374151;

    padding:12px 25px;

    border-radius:10px;

    text-decoration:none;

    font-weight:600;

    transition:.3s;

}

.btn-return:hover{

    background:#E5E7EB;

    color:#111827;

}

.btn-edit{

    background:var(--orange);

    color:white;

    padding:12px 28px;

    border-radius:10px;

    text-decoration:none;

    font-weight:600;

    transition:.3s;

}

.btn-edit:hover{

    background:#EA580C;

    color:white;

}

@media(max-width:768px){

.info-grid{

grid-template-columns:1fr;

}

.card-header{

flex-direction:column;
align-items:flex-start;

}

.buttons{

flex-direction:column;

}

.btn-return,
.btn-edit{

text-align:center;

}

}

</style>

</head>

<body>
    @php
    $profil = session('user')->profil ?? '';

    $admin = $profil === 'Administrateur';
    $serviceRH = $profil === 'RH';
    $commission = $profil === 'Commission';
    $responsableService = $profil === 'Responsable de service';
    $consultation = $profil === 'Consultation';
@endphp
 <div class="container-page">

    <div class="offer-card">

        <!-- En-tête -->

        <div class="card-header">

            <div class="title">

                <h2>
                    <i class="bi bi-file-earmark-text-fill text-warning"></i>
                    Détails de l'offre
                </h2>

                <p>
                    Consultez toutes les informations concernant cette offre de recrutement.
                </p>

            </div>

            @if($offre->statut == 'Ouverte')

                <span class="badge-status open">

                    <i class="bi bi-check-circle-fill"></i>

                    Ouverte

                </span>

            @else

                <span class="badge-status close">

                    <i class="bi bi-x-circle-fill"></i>

                    Fermée

                </span>

            @endif

        </div>

        <!-- Corps -->

        <div class="card-body">

            <h4 class="section-title">

                <i class="bi bi-info-circle-fill text-warning"></i>

                Informations générales

            </h4>

            <div class="info-grid">

                <div class="info-box">

                    <label>Référence de l'offre</label>

                    <span>{{ $offre->reference_offre }}</span>

                </div>

                <div class="info-box">

                    <label>Intitulé du poste</label>

                    <span>{{ $offre->intitule_poste }}</span>

                </div>

                <div class="info-box">

                    <label>Type de recrutement</label>

                    <span>{{ $offre->type_recrutement }}</span>

                </div>

                <div class="info-box">

                    <label>Nombre de postes</label>

                    <span>{{ $offre->nombre_postes }}</span>

                </div>

                <div class="info-box">

                    <label>Service concerné</label>

                    <span>{{ $offre->service_concerne }}</span>

                </div>

                <div class="info-box">

                    <label>Lieu d'affectation</label>

                    <span>{{ $offre->lieu_affectation }}</span>

                </div>

                <div class="info-box">

                    <label>Diplôme exigé</label>

                    <span>

                        {{ optional($offre->diplome)->libelle ?? '-' }}

                    </span>

                </div>

                <div class="info-box">

                    <label>Spécialité exigée</label>

                    <span>

                        {{ optional($offre->specialite)->libelle ?? '-' }}

                    </span>

                </div>

                <div class="info-box">

                    <label>Expérience exigée</label>

                    <span>{{ $offre->experience_exigee }}</span>

                </div>

                <div class="info-box">

                    <label>Date de publication</label>

                    <span>{{ $offre->date_publication }}</span>

                </div>

                <div class="info-box">

                    <label>Date limite de dépôt</label>

                    <span>{{ $offre->date_limite_depot }}</span>

                </div>

                <div class="info-box">

                    <label>Statut</label>

                    <span>{{ $offre->statut }}</span>

                </div>

            </div>
                        <!-- Description -->

            <div class="text-card">

                <h5>

                    <i class="bi bi-card-text text-warning"></i>

                    Description du poste

                </h5>

                <p>

                    {{ $offre->description_poste ?: 'Aucune description disponible.' }}

                </p>

            </div>


            <!-- Conditions -->

            <div class="text-card">

                <h5>

                    <i class="bi bi-list-check text-warning"></i>

                    Conditions de participation

                </h5>

                <p>

                    {{ $offre->conditions_participation ?: 'Aucune condition renseignée.' }}

                </p>

            </div>


            <!-- Observations -->

            <div class="text-card">

                <h5>

                    <i class="bi bi-chat-left-text text-warning"></i>

                    Observations

                </h5>

                <p>

                    {{ $offre->observations ?: 'Aucune observation.' }}

                </p>

            </div>
                        <!-- Boutons -->

            <div class="buttons">

                <a href="{{ route('offres.index') }}" class="btn-return">

                    <i class="bi bi-arrow-left-circle"></i>

                    Retour à la liste

                </a>
            @if($admin || $serviceRH)
                <a href="{{ route('offres.edit', $offre->id_offre) }}" class="btn-edit">

                    <i class="bi bi-pencil-square"></i>

                    Modifier

                </a>
                @endif
            @if($admin || $serviceRH)
                <form action="{{ route('offres.destroy', $offre->id_offre) }}"
                      method="POST"
                      onsubmit="return confirm('Voulez-vous vraiment supprimer cette offre ?');">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-danger px-4 py-2 rounded-3">

                        <i class="bi bi-trash-fill"></i>

                        Supprimer

                    </button>

                </form>
@endif
            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
