<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Gestion des offres | ORMVASM</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

:root{

    --orange:#F97316;
    --green:#15803D;
    --blue:#0284C7;

    --bg:#F5F7F6;
    --white:#FFFFFF;

    --text:#1F2937;
    --text-light:#6B7280;

    --border:#E5E7EB;

    --success:#DCFCE7;
    --danger:#FEE2E2;

    --shadow:0 8px 25px rgba(0,0,0,.06);

}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    font-family:"Segoe UI",sans-serif;
    background:var(--bg);
    color:var(--text);

}

a{

    text-decoration:none;

}

img{

    display:block;
    max-width:100%;

}

/*==================================================
                    TOPBAR
==================================================*/

.topbar{

    height:70px;
    background:#fff;

    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:0 30px;

    border-bottom:1px solid var(--border);

}

.topbar-left{

    display:flex;
    align-items:center;
    gap:14px;

}

.topbar-logo{
    text-align: center;
    padding: 20px 20px;
    width: 130px;
    max-width: 100%;
    height: auto;
    display: block;
   }

.topbar-left h5{

    margin:0;

    color:var(--green);

    font-size:16px;

    font-weight:600;

}

.topbar-center{

    display:flex;

    align-items:center;

    gap:15px;

}

.search{

    width:330px;

    position:relative;

}

.search i{

    position:absolute;

    left:15px;

    top:50%;

    transform:translateY(-50%);

    color:#9CA3AF;

}

.search input{

    width:100%;

    height:42px;

    border:1px solid var(--border);

    border-radius:25px;

    padding-left:42px;

    outline:none;

    transition:.3s;

}

.search input:focus{

    border-color:var(--green);

    box-shadow:0 0 0 3px rgba(21,128,61,.12);

}

.topbar-center select{

    width:200px;

    height:42px;

    border-radius:25px;

    border:1px solid var(--border);

}

.user{

    display:flex;

    align-items:center;

    gap:15px;

}

.user i{

    font-size:20px;

    color:#4B5563;

}

.avatar{

    width:42px;

    height:42px;

    border-radius:50%;

    background:var(--blue);

    color:#fff;

    display:flex;

    justify-content:center;

    align-items:center;

    font-weight:600;

}

/*==================================================
                    CONTENU
==================================================*/

.content{

    max-width:1300px;

    margin:auto;

    padding:35px;

}

.page-title{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:30px;

    flex-wrap:wrap;

    gap:15px;

}

.page-title h2{

    font-size:32px;

    font-weight:700;

}

.page-title p{

    color:var(--text-light);

}

.btn-add{

    background:var(--orange);

    color:#fff;

    padding:12px 22px;

    border-radius:10px;

    font-weight:600;

    transition:.3s;

}

.btn-add:hover{

    background:#df650e;

    color:#fff;

}

.card{

    border:none;

    border-radius:15px;

    box-shadow:var(--shadow);

    padding:20px;

}

.table{

    margin:0;

}

.table thead{

    background:#F8FAFC;

}

.table th{

    font-weight:600;

    white-space:nowrap;

}

.table th,
.table td{

    padding:15px;

    vertical-align:middle;

}

.badge-open{

    background:#DCFCE7;

    color:#166534;

    padding:7px 15px;

    border-radius:20px;

}

.badge-close{

    background:#FEE2E2;

    color:#991B1B;

    padding:7px 15px;

    border-radius:20px;

}

.action{

    display:flex;

    gap:10px;

}

.action a,
.action button{

    width:38px;

    height:38px;

    border:none;

    border-radius:8px;

    background:#F8FAFC;

    display:flex;

    justify-content:center;

    align-items:center;

    transition:.25s;

}

.text-show{

    color:#16A34A;

}

.text-edit{

    color:#0284C7;

}

.text-delete{

    color:#DC2626;

}

.action a:hover,
.action button:hover{

    background:#EEF2F7;

    transform:scale(1.08);

}

.pagination{

    justify-content:center;

    margin-top:25px;

}

@media(max-width:1200px){

.topbar-center{

display:none;

}

}

@media(max-width:768px){

.topbar{

padding:15px;

height:auto;

flex-wrap:wrap;

gap:15px;

}

.topbar-left h5{

display:none;

}

.content{

padding:20px;

}

.page-title{

flex-direction:column;

align-items:flex-start;

}

.btn-add{

width:100%;
text-align:center;

}

}

</style>
<body>

<div class="main">

    <!-- ===========================
                TOPBAR
    ============================ -->

    <div class="topbar">

        <div class="topbar-left">

            <img src="{{ asset('image/ormvaa.png') }}" class="topbar-logo">

            <h5>
                Office Régional de Mise en Valeur Agricole
                du Souss Massa
            </h5>

        </div>

        <div class="topbar-center">

            <div class="search">

                <i class="bi bi-search"></i>

                <input
                    type="text"
                    id="tableSearch"
                    placeholder="Rechercher une offre...">

            </div>

            <select id="typeFilter" class="form-select">

                <option value="">Tous les types</option>
                <option value="Interne">Interne</option>
                <option value="Externe">Externe</option>

            </select>

            <select id="statutFilter" class="form-select">

                <option value="">Tous les statuts</option>
                <option value="Ouverte">Ouverte</option>
                <option value="Fermée">Fermée</option>

            </select>

        </div>

        <div class="user">

            <i class="bi bi-bell fs-5"></i>

            <div class="avatar">
                RH
            </div>

        </div>

    </div>

    <!-- ===========================
                CONTENU
    ============================ -->

    <div class="content">

        <div class="page-title">

            <div>

                <h2>Gestion des offres</h2>

                <p>
                    Liste des offres de recrutement.
                </p>

            </div>

            <a href="{{ route('offres.create') }}" class="btn-add">

                <i class="bi bi-plus-circle"></i>

                Ajouter une offre

            </a>

        </div>

        @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

        @endif

        <div class="card">

            <div class="table-responsive">

                <table class="table align-middle" id="offresTable">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Référence</th>

                            <th>Intitulé</th>

                            <th>Type</th>

                            <th>Postes</th>

                            <th>Date publication</th>

                            <th>Date limite</th>

                            <th>Statut</th>

                            <th width="170">Actions</th>

                        </tr>

                    </thead>

                    <tbody>
                        @forelse($offres as $offre)

<tr>

    <td>{{ $offre->id_offre }}</td>

    <td>{{ $offre->reference_offre }}</td>

    <td>{{ $offre->intitule_poste }}</td>

    <td>{{ $offre->type_recrutement }}</td>

    <td>{{ $offre->nombre_postes }}</td>

    <td>{{ $offre->date_publication }}</td>

    <td>{{ $offre->date_limite_depot }}</td>

    <td>

        @if($offre->statut == "Ouverte")

            <span class="badge-open">

                Ouverte

            </span>

        @else

            <span class="badge-close">

                {{ $offre->statut }}

            </span>

        @endif

    </td>

    <td>

        <div class="action">

            <a
                href="{{ route('offres.show',$offre->id_offre) }}"
                class="text-show"
                title="Afficher">

                <i class="bi bi-eye-fill"></i>

            </a>

            <a
                href="{{ route('offres.edit',$offre->id_offre) }}"
                class="text-edit"
                title="Modifier">

                <i class="bi bi-pencil-square"></i>

            </a>

            <form
                action="{{ route('offres.destroy',$offre->id_offre) }}"
                method="POST"
                style="display:inline;"
                onsubmit="return confirm('Voulez-vous vraiment supprimer cette offre ?')">

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="text-delete"
                    title="Supprimer">

                    <i class="bi bi-trash-fill"></i>

                </button>

            </form>

        </div>

    </td>

</tr>

@empty

<tr>

    <td colspan="9" class="text-center py-5">

        <i class="bi bi-folder2-open fs-1 text-secondary"></i>

        <br><br>

        Aucune offre disponible.

    </td>

</tr>

@endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-4">

                {{ $offres->links() }}

            </div>

        </div>

    </div>
    <script>
 const search = document.getElementById("tableSearch");
const type = document.getElementById("typeFilter");
const statut = document.getElementById("statutFilter");

function filtrer() {

    const texte = search.value.toLowerCase();
    const typeChoisi = type.value.toLowerCase();
    const statutChoisi = statut.value.toLowerCase();

    const rows = document.querySelectorAll("#offresTable tbody tr");

    rows.forEach(function(row){

        const contenu = row.innerText.toLowerCase();

        const typeOffre = row.cells[3].innerText.toLowerCase();
        const statutOffre = row.cells[7].innerText.toLowerCase();

        const okRecherche = contenu.includes(texte);
        const okType = typeChoisi === "" || typeOffre === typeChoisi;
        const okStatut = statutChoisi === "" || statutOffre.includes(statutChoisi);

        row.style.display = (okRecherche && okType && okStatut)
            ? ""
            : "none";

    });

}

search.addEventListener("keyup", filtrer);
type.addEventListener("change", filtrer);
statut.addEventListener("change", filtrer);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>