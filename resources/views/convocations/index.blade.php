<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Gestion des convocations | ORMVASM</title>

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

/*==========================
        TOPBAR
==========================*/

.topbar{

    position:fixed;
    top:0;
    left:0;
    right:0;

    height:75px;

    background:#fff;

    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:0 30px;

    border-bottom:1px solid var(--border);

    box-shadow:0 2px 10px rgba(0,0,0,.05);

    z-index:999;

}

.topbar-left{

    display:flex;
    align-items:center;
    gap:15px;

}

.topbar-logo{

    width:60px;
    height:60px;
    object-fit:contain;

}

.topbar-left h5{

    margin:0;
    color:var(--green);
    font-size:17px;
    font-weight:600;

}

.topbar-center{

    flex:1;
    display:flex;
    justify-content:center;
    gap:15px;

}

.search{

    width:340px;
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

    border-radius:30px;

    border:1px solid var(--border);

    padding-left:45px;

    outline:none;

}

.search input:focus{

    border-color:var(--green);

    box-shadow:0 0 0 3px rgba(21,128,61,.15);

}

.topbar-center select{

    width:180px;
    height:42px;
    border-radius:30px;

}

.user{

    display:flex;
    align-items:center;
    gap:20px;

}

.notification{

    position:relative;

}

.notification i{

    font-size:22px;
    color:#4B5563;

}

.notification-badge{

    position:absolute;

    top:-6px;
    right:-6px;

    background:#EF4444;

    color:white;

    border-radius:20px;

    padding:2px 6px;

    font-size:11px;

}

.user-info{

    display:flex;
    flex-direction:column;
    align-items:flex-end;

}

.user-info small{

    color:#6B7280;

}

.user-info strong{

    font-size:14px;

}

.avatar{

    width:42px;
    height:42px;

    border-radius:50%;

    background:#2563EB;

    color:white;

    display:flex;
    justify-content:center;
    align-items:center;

    font-weight:bold;

}

.main{

    margin-left:260px;
    width:calc(100% - 260px);

}

.content{

    padding:35px;
    padding-top:95px;

}

.page-title{

    display:flex;
    justify-content:space-between;
    align-items:center;

    margin-bottom:30px;

}

.page-title h2{

    font-size:32px;
    font-weight:700;

}

.page-title p{

    color:#6B7280;

}

.btn-add{

    background:var(--orange);
    color:white;

    padding:12px 22px;

    border-radius:10px;

    font-weight:600;

}

.btn-add:hover{

    background:#df650e;
    color:white;

}

.card{

    border:none;

    border-radius:15px;

    box-shadow:var(--shadow);

    padding:20px;

}

.table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
    border-radius:18px;
    overflow:hidden;
}

.table thead th{
    padding:18px 20px;
    font-size:17px;
    font-weight:700;
    color:#374151;
    background:#FFFFFF;
    border-bottom:1px solid #E5E7EB;
    white-space:nowrap;
}

.table tbody td{
    padding:18px 20px;
    font-size:16px;
    font-weight:500;
    color:#1F2937;
    vertical-align:middle;
    border-bottom:1px solid #F1F5F9;
}

.table tbody tr:hover{
    background:#F9FAFB;
}
.table th:nth-child(1),
.table td:nth-child(1){
    width:220px;
}

.table th:nth-child(2),
.table td:nth-child(2){
    width:240px;
}

.table th:nth-child(3),
.table td:nth-child(3){
    width:120px;
}

.table th:nth-child(4),
.table td:nth-child(4){
    width:110px;
}

.table th:nth-child(5),
.table td:nth-child(5){
    width:110px;
}

.table th:nth-child(6),
.table td:nth-child(6){
    width:180px;
}

.table th:nth-child(7),
.table td:nth-child(7){
    width:160px;
}

.table th:nth-child(8),
.table td:nth-child(8){
    width:180px;
    text-align:center;
}

.table th:last-child,
.table td:last-child{
    width:150px;
    text-align:center;
}


.table th{
    font-size:17px;
}

.table td{
    font-size:16px;
}

.badge-planifiee{

    background:#DCFCE7;
    color:#166534;
    border-radius:20px;
    padding:6px 14px;

}

.badge-envoyee{

    background:#DBEAFE;
    color:#1D4ED8;
    border-radius:20px;
    padding:6px 14px;

}

.badge-annulee{

    background:#FEE2E2;
    color:#991B1B;
    border-radius:20px;
    padding:6px 14px;

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

    background:#F8FAFC;

    border-radius:8px;

    display:flex;
    justify-content:center;
    align-items:center;

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

.pagination{

    justify-content:center;
    margin-top:25px;

}
.badge-convoque{
    background:#DCFCE7;
    color:#166534;
    padding:7px 16px;
    border-radius:20px;
    font-weight:600;
}

.badge-present{
    background:#DBEAFE;
    color:#1D4ED8;
    padding:7px 16px;
    border-radius:20px;
    font-weight:600;
}

.badge-absent{
    background:#FEE2E2;
    color:#991B1B;
    padding:7px 16px;
    border-radius:20px;
    font-weight:600;
}

.badge-excuse{
    background:#FEF3C7;
    color:#92400E;
    padding:7px 16px;
    border-radius:20px;
    font-weight:600;
}
</style>

</head>

<body>

@include('layouts.sidebar')

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
                    placeholder="Rechercher une convocation...">

            </div>

            <select id="statutFilter" class="form-select">

              <option value="">Tous les statuts</option>

              <option value="Convoqué">Convoqué</option>

              <option value="Présent">Présent</option>

              <option value="Absent">Absent</option>

              <option value="Excusé">Excusé</option>

          </select>

        </div>

        <div class="user">

            <div class="notification">

                <i class="bi bi-bell fs-5"></i>

                @if(isset($nbNotifications) && $nbNotifications > 0)

                    <span class="notification-badge">

                        {{ $nbNotifications }}

                    </span>

                @endif

            </div>

            <div class="user-info">

                <small>

                    {{ session('user')->profil ?? 'Utilisateur' }}

                </small>

                <strong>

                    {{ session('user')->prenom ?? '' }}

                    {{ session('user')->nom ?? '' }}

                </strong>

            </div>

            <div class="avatar">

                {{ strtoupper(substr(session('user')->prenom ?? 'U',0,1)) }}

                {{ strtoupper(substr(session('user')->nom ?? '',0,1)) }}

            </div>

        </div>

    </div>


    <!-- ===========================
                CONTENU
    ============================ -->

    <div class="content">

        <div class="page-title">

            <div>

                <h2>

                    Gestion des convocations

                </h2>

                <p>

                    Liste des convocations des candidats.

                </p>

            </div>

            <a
                href="{{ route('convocations.create') }}"
                class="btn-add">

                <i class="bi bi-plus-circle"></i>

                Nouvelle convocation

            </a>

        </div>


        @if(session('success'))

            <div class="alert alert-success">

                <i class="bi bi-check-circle-fill me-2"></i>

                {{ session('success') }}

            </div>

        @endif


        @if(session('error'))

            <div class="alert alert-danger">

                <i class="bi bi-exclamation-triangle-fill me-2"></i>

                {{ session('error') }}

            </div>

        @endif


        <div class="card">

            <div class="table-responsive">

                <table
                    class="table align-middle"
                    id="convocationsTable">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Candidat</th>

                            <th>Offre</th>

                            <th>Date</th>

                            <th>Heure</th>

                            <th>Type</th>

                            <th>Lieu</th>

                            <th>Présence</th>

                            <th width="170">

                                Actions

                            </th>

                        </tr>

                    </thead>

                    <tbody>
                     @forelse($convocations as $convocation)

<tr>

    <td>

        {{ $convocation->id_convocation }}

    </td>

    <td>

        <strong>

            {{ $convocation->candidature->candidat->nom ?? '-' }}

            {{ $convocation->candidature->candidat->prenom ?? '' }}

        </strong>

    </td>

    <td>

        {{ $convocation->candidature->offre->intitule_poste ?? '-' }}

    </td>

    <td>

        {{ \Carbon\Carbon::parse($convocation->date_convocation)->format('d/m/Y') }}

    </td>

    <td>

        {{ substr($convocation->heure_convocation,0,5) }}

    </td>

    <td>

        {{ $convocation->type_convocation }}

    </td>

    <td>

        {{ $convocation->lieu_convocation }}

    </td>

  <td>

@if($convocation->statut_presence == 'Convoqué')

    <span class="badge-convoque">
        {{ $convocation->statut_presence }}
    </span>

@elseif($convocation->statut_presence == 'Présent')

    <span class="badge-present">
        {{ $convocation->statut_presence }}
    </span>

@elseif($convocation->statut_presence == 'Absent')

    <span class="badge-absent">
        {{ $convocation->statut_presence }}
    </span>

@elseif($convocation->statut_presence == 'Excusé')

    <span class="badge-excuse">
        {{ $convocation->statut_presence }}
    </span>

@else

    {{ $convocation->statut_presence }}

@endif

</td>

    <td>

        <div class="action">

            <a
                href="{{ route('convocations.show',$convocation->id_convocation) }}"
                class="text-show"
                title="Afficher">

                <i class="bi bi-eye-fill"></i>

            </a>

            <a
                href="{{ route('convocations.edit',$convocation->id_convocation) }}"
                class="text-edit"
                title="Modifier">

                <i class="bi bi-pencil-square"></i>

            </a>

            <form
                action="{{ route('convocations.destroy',$convocation->id_convocation) }}"
                method="POST"
                style="display:inline;"
                onsubmit="return confirm('Voulez-vous supprimer cette convocation ?')">

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

        <i class="bi bi-calendar-x fs-1 text-secondary"></i>

        <br><br>

        Aucune convocation disponible.

    </td>

</tr>

@endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-4">

                {{ $convocations->links() }}

            </div>

        </div>

    </div>
                </tbody>

        </table>

    </div>

    <div class="mt-4">

        {{ $convocations->links() }}

    </div>

</div>
<script>

const search = document.getElementById('tableSearch');
const statut = document.getElementById('statutFilter');

function filtrerConvocations(){

    let texte = search.value.toLowerCase();
    let statutChoisi = statut.value.toLowerCase();

    document.querySelectorAll("#convocationsTable tbody tr").forEach(function(row){

        let contenu = row.innerText.toLowerCase();

        let statutCell = row.cells[7].innerText.toLowerCase();

        let okRecherche = contenu.includes(texte);

        let okStatut = statutChoisi === "" || statutCell.includes(statutChoisi);

        row.style.display = (okRecherche && okStatut)
            ? ""
            : "none";

    });

}

search.addEventListener("keyup", filtrerConvocations);
statut.addEventListener("change", filtrerConvocations);

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>