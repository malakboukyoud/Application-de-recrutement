<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Document</title>
 <style>
/*==================================================
                    TOPBAR
==================================================*/

.topbar{

    position:fixed;

    top:0;
    left:0;
    right:0;

    height:75px;

    background:#ffffff;

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:0 30px;

    border-bottom:1px solid #E5E7EB;

    box-shadow:0 2px 10px rgba(0,0,0,.05);

    z-index:1100;

}

/*==================================================
                    LEFT
==================================================*/

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

    color:#15803D;

    font-size:17px;

    font-weight:600;

    line-height:1.3;

}

/*==================================================
                    CENTER
==================================================*/

.topbar-center{

    flex:1;

    display:flex;

    justify-content:center;

}

.search{

    width:400px;

    position:relative;

}

.search i{

    position:absolute;

    left:15px;

    top:50%;

    transform:translateY(-50%);

    color:#9CA3AF;

    font-size:15px;

}

.search input{

    width:100%;

    height:44px;

    border:1px solid #D1D5DB;

    border-radius:30px;

    padding-left:45px;

    padding-right:20px;

    outline:none;

    transition:.3s;

    font-size:14px;

}

.search input:focus{

    border-color:#15803D;

    box-shadow:0 0 0 3px rgba(21,128,61,.15);

}

/*==================================================
                    RIGHT
==================================================*/

.user{

    display:flex;

    align-items:center;

    gap:20px;

}

/*==================================================
                NOTIFICATION
==================================================*/

.notification{

    position:relative;

    cursor:pointer;

}

.notification i{

    font-size:22px;

    color:#4B5563;

    transition:.3s;

}

.notification:hover i{

    color:#15803D;

}

.notification-badge{

    position:absolute;

    top:-6px;

    right:-8px;

    min-width:18px;

    height:18px;

    padding:0 5px;

    background:#EF4444;

    color:#fff;

    border-radius:50px;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:11px;

    font-weight:600;

}

/*==================================================
                USER INFO
==================================================*/

.user-info{

    display:flex;

    flex-direction:column;

    align-items:flex-end;

    line-height:1.3;

}

.user-info small{

    color:#6B7280;

    font-size:12px;

}

.user-info strong{

    font-size:14px;

    color:#111827;

    font-weight:600;

}

/*==================================================
                    AVATAR
==================================================*/

.avatar{

    width:45px;

    height:45px;

    border-radius:50%;

    background:#2563EB;

    color:#fff;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:15px;

    font-weight:bold;

    cursor:pointer;

    transition:.3s;

}

.avatar:hover{

    transform:scale(1.05);

    box-shadow:0 5px 15px rgba(37,99,235,.25);

}

/*==================================================
                RESPONSIVE
==================================================*/

@media(max-width:992px){

    .topbar{

        padding:0 15px;

    }

    .topbar-left h5{

        display:none;

    }

    .search{

        width:250px;

    }

}

@media(max-width:768px){

    .search{

        display:none;

    }

    .user-info{

        display:none;

    }

}
 </style>
</head>
<body>
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
                placeholder="Rechercher...">

        </div>

    </div>

    <div class="user">

        <div class="notification">

            <i class="bi bi-bell fs-5"></i>

            @if($nbNotifications > 0)
                <span class="notification-badge">
                    {{ $nbNotifications }}
                </span>
            @endif

        </div>

        <div class="user-info">

            <small>{{ session('user')->profil ?? 'Utilisateur' }}</small>

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
<script>

document.getElementById('tableSearch').addEventListener('keyup', function(){

    let value = this.value.toLowerCase();

    let rows = document.querySelectorAll("table tbody tr");

    rows.forEach(function(row){

        let text = row.textContent.toLowerCase();

        if(text.includes(value)){

            row.style.display = "";

        }else{

            row.style.display = "none";

        }

    });

});

</script>
</body>
</html>
