<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestion des utilisateurs | ORMVASM</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    <style>

        /* =========================================================
                            VARIABLES
        ========================================================= */

        :root {

            --orange: #F97316;
            --orange-dark: #EA580C;
            --orange-light: #FFEDD5;

            --green: #15803D;
            --green-dark: #166534;
            --green-light: #DCFCE7;

            --blue: #0284C7;
            --blue-light: #E0F2FE;

            --purple: #9333EA;
            --purple-light: #F3E8FF;

            --red: #DC2626;
            --red-light: #FEE2E2;

            --bg: #F5F7F6;
            --white: #FFFFFF;

            --text: #1F2937;
            --text-light: #6B7280;

            --border: #E5E7EB;

            --shadow: 0 8px 25px rgba(15, 23, 42, 0.06);

            --sidebar-width: 240px;
            --topbar-height: 75px;
        }


        /* =========================================================
                            RESET
        ========================================================= */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        


body{


            background: var(--bg);

            color: var(--text);

            min-height: 100vh;

            overflow-x: hidden;
        }

        a {
            text-decoration: none;
        }

        button,
        input,
        select {
            font-family: inherit;
        }


        /* =========================================================
                            TOPBAR
        ========================================================= */

        .topbar {

            position: fixed;

            top: 0;
            left: 0;
            right: 0;

            width: 100%;
            height: var(--topbar-height);

            background: var(--white);

            display: flex;
            align-items: center;

            padding: 0 25px;

            border-bottom: 1px solid var(--border);

            box-shadow: 0 2px 12px rgba(15, 23, 42, .06);

            z-index: 5000;
        }


        /* =========================================================
                            TOPBAR GAUCHE
        ========================================================= */

        .ormvasm-topbar-left {

            display: flex;
            align-items: center;

            gap: 12px;

            flex-shrink: 0;

            width: 310px;
        }

        .ormvasm-brand {

            width: 55px;
            height: 55px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;
        }

        .ormvasm-brand img {

            width: 52px;
            height: 52px;

            object-fit: contain;
        }

        .ormvasm-brand-name {

            color: #17324D;

            font-size: 12px;

            line-height: 1.35;

            font-weight: 700;

            max-width: 220px;
        }


        /* =========================================================
                            TOPBAR CENTRE
        ========================================================= */

        .ormvasm-topbar-center {

            flex: 1;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 10px;

            padding: 0 20px;

            min-width: 0;
        }


        /* =========================================================
                            RECHERCHE
        ========================================================= */

        .ormvasm-search {

            width: 100%;

            max-width: 360px;

            height: 43px;

            position: relative;
        }

        .ormvasm-search i {

            position: absolute;

            left: 15px;
            top: 50%;

            transform: translateY(-50%);

            color: #64748B;

            font-size: 16px;

            z-index: 2;
        }

        .ormvasm-search input {

            width: 100%;
            height: 43px;

            border: 1px solid var(--border);

            border-radius: 11px;

            padding: 0 15px 0 43px;

            outline: none;

            background: #F8FAFC;

            color: var(--text);

            font-size: 13px;

            transition: .2s ease;
        }

        .ormvasm-search input::placeholder {
            color: #94A3B8;
        }

        .ormvasm-search input:focus {

            background: var(--white);

            border-color: var(--green);

            box-shadow: 0 0 0 3px rgba(21, 128, 61, .08);
        }


        /* =========================================================
                            SELECTS
        ========================================================= */

        .ormvasm-topbar-center select {

            width: 150px;
            height: 43px;

            padding: 0 12px;

            border-radius: 11px;

            border: 1px solid var(--border);

            background: #F8FAFC;

            color: #475569;

            font-size: 12px;

            outline: none;

            cursor: pointer;

            transition: .2s ease;
        }

        .ormvasm-topbar-center select:focus {

            background: var(--white);

            border-color: var(--green);

            box-shadow: 0 0 0 3px rgba(21, 128, 61, .08);
        }


        /* =========================================================
                            TOPBAR DROITE
        ========================================================= */

        .ormvasm-topbar-right {

            display: flex;

            align-items: center;

            justify-content: flex-end;

            gap: 15px;

            flex-shrink: 0;

            width: 260px;
        }


        /* =========================================================
                            NOTIFICATION
        ========================================================= */

        .ormvasm-notification {

            position: relative;
        }

        .ormvasm-notification-btn {

            position: relative;

            width: 43px;
            height: 43px;

            border: 1px solid var(--border);

            background: var(--white);

            border-radius: 11px;

            display: flex;

            align-items: center;
            justify-content: center;

            cursor: pointer;

            color: #475569;

            transition: .2s ease;
        }

        .ormvasm-notification-btn:hover {

            color: var(--green);

            border-color: var(--green);

            background: #F0FDF4;
        }

        .ormvasm-notification-btn i {
            font-size: 18px;
        }

        .ormvasm-notification-badge {

            position: absolute;

            top: -5px;
            right: -5px;

            min-width: 19px;
            height: 19px;

            padding: 0 5px;

            border-radius: 20px;

            display: flex;

            align-items: center;
            justify-content: center;

            background: var(--red);

            color: white;

            border: 2px solid white;

            font-size: 9px;

            font-weight: 700;
        }


        /* =========================================================
                        PANNEAU NOTIFICATIONS
        ========================================================= */

        .ormvasm-notification-panel {

            position: absolute;

            top: 55px;
            right: 0;

            width: 380px;

            max-height: 550px;

            background: white;

            border: 1px solid var(--border);

            border-radius: 15px;

            box-shadow: 0 15px 45px rgba(15, 23, 42, .15);

            overflow: hidden;

            opacity: 0;

            visibility: hidden;

            transform: translateY(-8px);

            transition: .2s ease;

            z-index: 6000;
        }

        .ormvasm-notification-panel.active {

            opacity: 1;

            visibility: visible;

            transform: translateY(0);
        }

        .ormvasm-notification-header {

            padding: 18px 20px;

            border-bottom: 1px solid var(--border);
        }

        .ormvasm-notification-title {

            color: #17324D;

            font-size: 15px;

            font-weight: 700;
        }

        .ormvasm-notification-subtitle {

            margin-top: 4px;

            color: var(--text-light);

            font-size: 11px;
        }

        .ormvasm-notification-list {

            max-height: 410px;

            overflow-y: auto;
        }

        .ormvasm-notification-item {

            display: flex;

            gap: 12px;

            padding: 15px 18px;

            border-bottom: 1px solid #F1F5F9;

            transition: .2s;

            color: inherit;
        }

        .ormvasm-notification-item:hover {
            background: #F8FAFC;
        }

        .ormvasm-notification-icon {

            width: 38px;
            height: 38px;

            min-width: 38px;

            border-radius: 10px;

            display: flex;

            align-items: center;
            justify-content: center;
        }

        .ormvasm-notification-icon.orange {

            background: var(--orange-light);

            color: var(--orange);
        }

        .ormvasm-notification-icon.blue {

            background: var(--blue-light);

            color: var(--blue);
        }

        .ormvasm-notification-icon.red {

            background: var(--red-light);

            color: var(--red);
        }

        .ormvasm-notification-icon.green {

            background: var(--green-light);

            color: var(--green);
        }

        .ormvasm-notification-content {
            min-width: 0;
        }

        .ormvasm-notification-content strong {

            display: block;

            color: var(--text);

            font-size: 12px;
        }

        .ormvasm-notification-content p {

            margin: 4px 0;

            color: var(--text-light);

            font-size: 11px;

            line-height: 1.4;
        }

        .ormvasm-notification-time {

            color: #94A3B8;

            font-size: 10px;
        }

        .ormvasm-notification-footer {

            padding: 13px 18px;

            border-top: 1px solid var(--border);

            text-align: center;
        }

        .ormvasm-notification-footer a {

            color: var(--green);

            font-size: 11px;

            font-weight: 600;
        }

        .ormvasm-empty {

            padding: 40px 20px;

            text-align: center;

            color: #94A3B8;
        }

        .ormvasm-empty i {

            font-size: 30px;

            color: var(--green);

            margin-bottom: 10px;
        }


        /* =========================================================
                            UTILISATEUR
        ========================================================= */

        .ormvasm-user {

            position: relative;

            display: flex;

            align-items: center;

            gap: 10px;

            cursor: pointer;

            padding: 5px 7px;

            border-radius: 11px;
        }

        .ormvasm-user:hover {
            background: #F8FAFC;
        }

        .ormvasm-user-label {

            display: flex;

            flex-direction: column;

            align-items: flex-end;

            line-height: 1.3;
        }

        .ormvasm-user-label strong {

            color: var(--text);

            font-size: 12px;

            font-weight: 700;
        }

        .ormvasm-user-label span {

            margin-top: 3px;

            color: var(--text-light);

            font-size: 10px;
        }

        .ormvasm-user-avatar {

            width: 43px;
            height: 43px;

            border-radius: 50%;

            display: flex;

            align-items: center;
            justify-content: center;

            background: var(--green);

            color: white;

            font-size: 13px;

            font-weight: 700;
        }


        /* =========================================================
                        MENU UTILISATEUR
        ========================================================= */

        .ormvasm-user-menu {

            position: absolute;

            top: 56px;
            right: 0;

            width: 230px;

            background: white;

            border: 1px solid var(--border);

            border-radius: 13px;

            box-shadow: 0 15px 40px rgba(15, 23, 42, .14);

            padding: 8px;

            opacity: 0;

            visibility: hidden;

            transform: translateY(-8px);

            transition: .2s ease;

            z-index: 6000;
        }

        .ormvasm-user-menu.active {

            opacity: 1;

            visibility: visible;

            transform: translateY(0);
        }

        .ormvasm-user-menu a,
        .ormvasm-user-menu button {

            width: 100%;

            min-height: 42px;

            display: flex;

            align-items: center;

            gap: 10px;

            padding: 0 12px;

            border: 0;

            border-radius: 9px;

            background: transparent;

            color: #334155;

            font-size: 12px;

            text-align: left;

            cursor: pointer;
        }

        .ormvasm-user-menu a:hover,
        .ormvasm-user-menu button:hover {

            background: #F0FDF4;

            color: var(--green);
        }

        .ormvasm-user-menu i {

            width: 18px;

            text-align: center;

            font-size: 15px;
        }

        .ormvasm-user-menu hr {

            border: 0;

            border-top: 1px solid var(--border);

            margin: 7px 0;
        }


        /* =========================================================
                            PAGE
        ========================================================= */

        .page {

            width: calc(100% - var(--sidebar-width));

            margin-left: var(--sidebar-width);

            padding-top: calc(var(--topbar-height) + 30px);

            padding-left: 30px;

            padding-right: 30px;

            padding-bottom: 40px;

            min-height: 100vh;
        }


        /* =========================================================
                        CONTENU CENTRAL
        ========================================================= */

        .page-content {

            width: 100%;

            max-width: 1400px;

            margin: 0 auto;
        }


        /* =========================================================
                            TITRE
        ========================================================= */

        .page-title {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 28px;

            gap: 20px;

            flex-wrap: wrap;
        }

        .page-title h2 {

            font-size: 30px;

            font-weight: 700;

            color: #111827;

            margin-bottom: 5px;
        }

        .page-title p {

            color: var(--text-light);

            font-size: 14px;

            margin: 0;
        }


        /* =========================================================
                            BOUTON AJOUT
        ========================================================= */

        .btn-add {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            background: var(--orange);

            color: white;

            padding: 11px 20px;

            border-radius: 10px;

            font-size: 14px;

            font-weight: 600;

            transition: .25s ease;

            border: none;
        }

        .btn-add:hover {

            background: var(--orange-dark);

            color: white;

            transform: translateY(-2px);

            box-shadow: 0 7px 18px rgba(249, 115, 22, .2);
        }


        /* =========================================================
                        CARTES STATISTIQUES
        ========================================================= */

        .cards {

            display: grid;

            grid-template-columns: repeat(4, minmax(0, 1fr));

            gap: 20px;

            width: 100%;

            margin-bottom: 28px;
        }

        .card-item {

            background: white;

            border: 1px solid var(--border);

            border-radius: 15px;

            padding: 21px;

            min-width: 0;

            display: flex;

            align-items: center;

            gap: 17px;

            box-shadow: var(--shadow);

            transition: .25s ease;
        }

        .card-item:hover {

            transform: translateY(-3px);

            box-shadow: 0 12px 30px rgba(15, 23, 42, .09);
        }

        .icon {

            width: 58px;
            height: 58px;

            min-width: 58px;

            border-radius: 14px;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 25px;
        }

        .icon.blue {

            background: var(--blue-light);

            color: var(--blue);
        }

        .icon.green {

            background: var(--green-light);

            color: #16A34A;
        }

        .icon.orange {

            background: var(--orange-light);

            color: var(--orange);
        }

        /* IMPORTANT :
           carte Administrateurs */
        .icon.purple {

            background: var(--purple-light);

            color: var(--purple);
        }

        .card-item h5 {

            margin: 0;

            font-size: 14px;

            color: var(--text-light);

            font-weight: 500;
        }

        .card-item h2 {

            margin: 5px 0 0;

            font-size: 29px;

            line-height: 1;

            font-weight: 700;

            color: #111827;
        }


        /* =========================================================
                            TABLE CARD
        ========================================================= */

        .table-card {

            width: 100%;

            background: white;

            border: 1px solid var(--border);

            border-radius: 15px;

            box-shadow: var(--shadow);

            overflow: hidden;
        }

        .table-responsive {

            width: 100%;

            overflow-x: auto;
        }

        .table {

            margin: 0;

            width: 100%;

            min-width: 900px;
        }

        .table thead {

            background: #F8FAFC;
        }

        .table thead th {

            border-bottom: 1px solid var(--border);

            padding: 15px;

            font-size: 13px;

            color: #374151;

            font-weight: 600;

            white-space: nowrap;
        }

        .table tbody td {

            padding: 15px;

            vertical-align: middle;

            border-bottom: 1px solid #F1F5F9;

            font-size: 13px;

            color: #374151;
        }

        .table tbody tr {

            transition: .2s ease;
        }

        .table tbody tr:hover {

            background: #F8FAFC;
        }


        /* =========================================================
                            BADGES
        ========================================================= */

        .badge {

            display: inline-flex;

            align-items: center;

            gap: 5px;

            padding: 6px 11px;

            border-radius: 20px;

            font-size: 11px;

            font-weight: 600;
        }

        .badge-admin {

            background: #DBEAFE;

            color: #1D4ED8;
        }

        .badge-rh {

            background: #DCFCE7;

            color: #15803D;
        }

        .badge-commission {

            background: #F3E8FF;

            color: #7E22CE;
        }

        .badge-consult {

            background: #F3F4F6;

            color: #4B5563;
        }

        .badge-resp {

            background: #FFEDD5;

            color: #C2410C;
        }

        .badge-active {

            background: #DCFCE7;

            color: #166534;
        }

        .badge-inactive {

            background: #FEE2E2;

            color: #991B1B;
        }

        .badge-active .bi,
        .badge-inactive .bi {

            font-size: 7px;
        }


        /* =========================================================
                            ACTIONS
        ========================================================= */

        .actions {

            display: flex;

            align-items: center;

            gap: 7px;
        }

        .btn-action {

            width: 36px;
            height: 36px;

            border: 1px solid transparent;

            border-radius: 8px;

            background: #F8FAFC;

            display: flex;

            justify-content: center;

            align-items: center;

            transition: .2s ease;

            cursor: pointer;
        }

        .btn-action:hover {

            transform: translateY(-2px);

            background: #EEF2F7;
        }

        .btn-view {
            color: #16A34A;
        }

        .btn-edit {
            color: #0284C7;
        }

        .btn-delete {
            color: #DC2626;
        }


        /* =========================================================
                            PAGINATION
        ========================================================= */

        .pagination {

            justify-content: center;

            margin: 0;

            padding: 20px;
        }

        .pagination .page-link {

            color: #374151;

            border-radius: 8px;

            margin: 0 3px;

            border: 1px solid var(--border);
        }

        .pagination .active .page-link {

            background: var(--orange);

            border-color: var(--orange);

            color: white;
        }


        /* =========================================================
                            ALERTES
        ========================================================= */

        .alert {

            border: none;

            border-radius: 12px;

            padding: 14px 18px;

            margin-bottom: 20px;

            font-weight: 500;
        }

        .alert-success {

            background: #ECFDF5;

            color: #166534;
        }

        .alert-danger {

            background: #FEF2F2;

            color: #991B1B;
        }

        .alert-warning {

            background: #FFF7ED;

            color: #9A3412;
        }


        /* =========================================================
                            SCROLLBAR
        ========================================================= */

        ::-webkit-scrollbar {

            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {

            background: #F3F4F6;
        }

        ::-webkit-scrollbar-thumb {

            background: #CBD5E1;

            border-radius: 20px;
        }

        ::-webkit-scrollbar-thumb:hover {

            background: #94A3B8;
        }


        /* =========================================================
                            ANIMATION
        ========================================================= */

        .card-item,
        .table-card {

            animation: fadeIn .45s ease;
        }

        @keyframes fadeIn {

            from {

                opacity: 0;

                transform: translateY(10px);
            }

            to {

                opacity: 1;

                transform: translateY(0);
            }
        }


        /* =========================================================
                        RESPONSIVE 1200
        ========================================================= */

        @media(max-width: 1200px) {

            .cards {

                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .ormvasm-topbar-left {

                width: 250px;
            }

            .ormvasm-brand-name {

                font-size: 10px;
            }

            .ormvasm-topbar-right {

                width: 210px;
            }

            .ormvasm-search {

                max-width: 270px;
            }

            .ormvasm-topbar-center select {

                width: 130px;
            }
        }


        /* =========================================================
                        RESPONSIVE 992
        ========================================================= */

        @media(max-width: 992px) {

            :root {

                --sidebar-width: 0px;
            }

            .page {

                width: 100%;

                margin-left: 0;

                padding-left: 20px;

                padding-right: 20px;
            }

            .ormvasm-topbar-left {

                width: auto;
            }

            .ormvasm-brand-name {

                display: none;
            }

            .ormvasm-topbar-center {

                padding: 0 10px;
            }

            .ormvasm-topbar-right {

                width: auto;
            }
        }


        /* =========================================================
                        RESPONSIVE 768
        ========================================================= */

        @media(max-width: 768px) {

            .topbar {

                height: 70px;

                padding: 0 15px;
            }

            .ormvasm-topbar-center {

                display: none;
            }

            .ormvasm-topbar-left {

                flex: 1;
            }

            .ormvasm-topbar-right {

                gap: 8px;
            }

            .ormvasm-user-label {

                display: none;
            }

            .page {

                padding-top: 95px;

                padding-left: 15px;

                padding-right: 15px;
            }

            .page-title {

                align-items: flex-start;

                flex-direction: column;
            }

            .page-title h2 {

                font-size: 26px;
            }

            .btn-add {

                width: 100%;
            }

            .cards {

                grid-template-columns: 1fr;

                gap: 15px;
            }

            .table-card {

                border-radius: 12px;
            }

            .ormvasm-notification-panel {

                position: fixed;

                top: 80px;

                left: 10px;

                right: 10px;

                width: auto;
            }
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

    color:#15803D;

    font-size:17px;

    font-weight:600;

    line-height:1.3;

}

/* =========================================================
   GAUCHE
========================================================= */

.ormvasm-topbar-left{

    display:flex;

    align-items:center;

    gap:13px;

    flex-shrink:0;

    min-width:390px;

}

        /* =========================================================
                        RESPONSIVE 576
        ========================================================= */

        @media(max-width: 576px) {

            .ormvasm-brand {

                width: 45px;

                height: 45px;
            }

            .ormvasm-brand img {

                width: 43px;

                height: 43px;
            }

            .ormvasm-notification-btn {

                width: 40px;

                height: 40px;
            }

            .ormvasm-user-avatar {

                width: 40px;

                height: 40px;
            }

            .page-title h2 {

                font-size: 23px;
            }

            .page-title p {

                font-size: 12px;
            }

            .card-item {

                padding: 18px;
            }

            .icon {

                width: 50px;

                height: 50px;

                min-width: 50px;

<<<<<<< HEAD
.content{

    padding:35px;
    padding-top:95px;
    max-width:1300px;
    margin:auto;

}

/*==================================================
                    TITRE
==================================================*/

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

    margin-bottom:5px;

}

.page-title p{

    color:var(--text-light);

}


/*==================================================
                    BOUTON
==================================================*/

.btn-add{

    background:var(--orange);
    color:white;

    padding:12px 22px;

    border-radius:10px;

    font-weight:600;

    transition:.3s;

}

.btn-add:hover{

    background:#DF650E;
    color:white;

    transform:translateY(-2px);

}
/*==================================================
                CARTES STATISTIQUES
==================================================*/

.cards{

    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:30px;

}

.card-item{

    background:var(--white);

    border:1px solid var(--border);

    border-radius:15px;

    padding:22px;

    display:flex;
    align-items:center;
    gap:18px;

    box-shadow:var(--shadow);

    transition:.3s;

}

.card-item:hover{

    transform:translateY(-3px);

}

.icon{

    width:60px;
    height:60px;

    border-radius:15px;

    display:flex;
    justify-content:center;
    align-items:center;

    font-size:28px;

}

.icon.blue{

    background:#E0F2FE;
    color:#0284C7;

}

.icon.green{

    background:#DCFCE7;
    color:#16A34A;

}

.icon.orange{

    background:#FFEDD5;
    color:#EA580C;

}

.icon.purple{

    background:#F3E8FF;
    color:#9333EA;

}

.card-item h5{

    margin:0;
    font-size:15px;
    color:#6B7280;
    font-weight:500;

}

.card-item h2{

    margin-top:6px;
    margin-bottom:0;

    font-size:30px;
    font-weight:700;

}


/*==================================================
                    TABLE
==================================================*/

.table-card{

    background:var(--white);

    border:1px solid var(--border);

    border-radius:15px;

    box-shadow:var(--shadow);

    overflow:hidden;

}

.table-responsive{

    overflow-x:hidden;

}

.table{

    margin:0;

}

.table thead{

    background:#F8FAFC;

}

.table thead th{

    border-bottom:1px solid var(--border);

    padding:16px;

    font-size:14px;

    color:#374151;

    font-weight:600;

    white-space:nowrap;

}

.table tbody td{

    padding:16px;

    vertical-align:middle;

    border-bottom:1px solid #F1F5F9;

}

.table tbody tr{

    transition:.25s;

}


            .card-item h2 {

                font-size: 24px;
            }
        }

    </style>

</head>


<body>

    {{-- =========================================================
                            SIDEBAR
    ========================================================= --}}

    @include('layouts.sidebar')


    {{-- =========================================================
                        UTILISATEUR SESSION
    ========================================================= --}}

    @php

        $sessionUser = session('user');

        $profilSession = $sessionUser->profil ?? '';
        $prenomSession = $sessionUser->prenom ?? '';
        $nomSession = $sessionUser->nom ?? '';

        $userName = trim(
            $prenomSession . ' ' . $nomSession
        );

        if ($userName === '') {
            $userName = 'Utilisateur';
        }

        $userRole = $profilSession ?: 'Utilisateur';

        $userInitials =
            strtoupper(substr($prenomSession, 0, 1)) .
            strtoupper(substr($nomSession, 0, 1));

        if ($userInitials === '') {
            $userInitials = 'U';
        }

        $admin = $profilSession === 'Administrateur';

    @endphp


    {{-- =========================================================
                            TOPBAR
    ========================================================= --}}

    <div class="topbar">


        {{-- ================= GAUCHE ================= --}}

        <div class="topbar-left">

            <img src="{{ asset('image/ormvaa.png') }}" class="topbar-logo">

            <h5>
                Office Régional de Mise en Valeur Agricole
                du Souss Massa
            </h5>

        </div>

        {{-- ================= CENTRE ================= --}}

        <div class="ormvasm-topbar-center">

            <div class="ormvasm-search">

                <i class="bi bi-search"></i>

                <input
                    type="text"
                    id="searchUser"
                    placeholder="Rechercher un utilisateur..."
                >

            </div>


            <select
                id="profilFilter"
                class="form-select"
            >

                <option value="">
                    Tous les profils
                </option>

                <option value="Administrateur">
                    Administrateur
                </option>

                <option value="RH">
                    RH
                </option>

                <option value="Commission">
                    Commission
                </option>

                <option value="Consultation">
                    Consultation
                </option>

                <option value="Responsable de service">
                    Responsable de service
                </option>

            </select>


            <select
                id="statutFilter"
                class="form-select"
            >

                <option value="">
                    Tous les statuts
                </option>

                <option value="actif">
                    Actif
                </option>

                <option value="inactif">
                    Inactif
                </option>

            </select>

        </div>


        {{-- ================= DROITE ================= --}}

        <div class="ormvasm-topbar-right">


            {{-- ================= NOTIFICATION ================= --}}

            <div class="ormvasm-notification">

                <button
                    type="button"
                    class="ormvasm-notification-btn"
                    id="notificationButton"
                    title="Notifications"
                >

                    <i class="bi bi-bell"></i>


                    @if($nbNotifications > 0)

                        <span
                            class="ormvasm-notification-badge"
                            id="notificationBadge"
                        >

                            {{ $nbNotifications > 99 ? '99+' : $nbNotifications }}

                        </span>

                    @endif

                </button>


                {{-- ================= PANEL ================= --}}

                <div
                    class="ormvasm-notification-panel"
                    id="notificationPanel"
                >

                    <div class="ormvasm-notification-header">

                        <div class="ormvasm-notification-title">

                            Notifications

                        </div>

                        <div class="ormvasm-notification-subtitle">

                            <span id="notificationCount">

                                {{ $nbNotifications }}

                            </span>

                            notifications

                        </div>

                    </div>


                    <div class="ormvasm-notification-list">


                        {{-- CANDIDATURES --}}

                        @if($candidaturesEnAttente > 0)

                            <a
                                href="{{ url('/candidatures') }}"
                                class="ormvasm-notification-item"
                            >

                                <div class="ormvasm-notification-icon orange">

                                    <i class="bi bi-person-plus"></i>

                                </div>

                                <div class="ormvasm-notification-content">

                                    <strong>
                                        Nouvelles candidatures
                                    </strong>

                                    <p>
                                        {{ $candidaturesEnAttente }}
                                        candidature(s) en attente de traitement.
                                    </p>

                                    <span class="ormvasm-notification-time">
                                        À traiter
                                    </span>

                                </div>

                            </a>

                        @endif


                        {{-- DOSSIERS --}}

                        @if($dossiersIncomplets > 0)

                            <a
                                href="{{ url('/candidatures') }}"
                                class="ormvasm-notification-item"
                            >

                                <div class="ormvasm-notification-icon blue">

                                    <i class="bi bi-folder-x"></i>

                                </div>

                                <div class="ormvasm-notification-content">

                                    <strong>
                                        Dossiers incomplets
                                    </strong>

                                    <p>
                                        {{ $dossiersIncomplets }}
                                        dossier(s) nécessitent une vérification.
                                    </p>

                                    <span class="ormvasm-notification-time">
                                        À vérifier
                                    </span>

                                </div>

                            </a>

                        @endif


                        {{-- OFFRES --}}

                        @if($offresExpirentBientot > 0)

                            <a
                                href="{{ url('/offres') }}"
                                class="ormvasm-notification-item"
                            >

                                <div class="ormvasm-notification-icon red">

                                    <i class="bi bi-clock-history"></i>

                                </div>

                                <div class="ormvasm-notification-content">

                                    <strong>
                                        Offres bientôt expirées
                                    </strong>

                                    <p>
                                        {{ $offresExpirentBientot }}
                                        offre(s) arrivent bientôt à échéance.
                                    </p>

                                    <span class="ormvasm-notification-time">
                                        Important
                                    </span>

                                </div>

                            </a>

                        @endif


                        {{-- CONVOCATIONS --}}

                        @if($convocationsAVenir > 0)

                            <a
                                href="{{ url('/convocations') }}"
                                class="ormvasm-notification-item"
                            >

                                <div class="ormvasm-notification-icon green">

                                    <i class="bi bi-calendar-event"></i>

                                </div>

                                <div class="ormvasm-notification-content">

                                    <strong>
                                        Convocations à venir
                                    </strong>

                                    <p>
                                        {{ $convocationsAVenir }}
                                        convocation(s) sont prévues.
                                    </p>

                                    <span class="ormvasm-notification-time">
                                        À consulter
                                    </span>

                                </div>

                            </a>

                        @endif


                        {{-- AUCUNE --}}

                        @if($nbNotifications == 0)

                            <div class="ormvasm-empty">

                                <i class="bi bi-check-circle"></i>

                                <p>
                                    Aucune notification.
                                </p>

                            </div>

                        @endif

                    </div>


                    <div class="ormvasm-notification-footer">

                        <a href="{{ url('/candidatures') }}">

                            Voir les candidatures

                            <i class="bi bi-arrow-right"></i>

                        </a>

                    </div>

                </div>

            </div>


            {{-- ================= MENU UTILISATEUR ================= --}}

            <div
                class="ormvasm-user"
                id="userMenuButton"
            >

                <div class="ormvasm-user-label">

                    <strong>
                        {{ $userName }}
                    </strong>

                    <span>
                        {{ $userRole }}
                    </span>

                </div>


                <div class="ormvasm-user-avatar">

                    {{ $userInitials }}

                </div>


                <div
                    class="ormvasm-user-menu"
                    id="userMenuPanel"
                >

                    @if($admin)

                        <a href="{{ route('historique.index') }}">

                            <i class="bi bi-clock-history"></i>

                            Historique des actions

                        </a>

                        <hr>

                    @endif


                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >

                        @csrf

                        <button type="submit">

                            <i class="bi bi-box-arrow-right"></i>

                            Déconnexion

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
                            PAGE
    ========================================================= --}}

    <main class="page">

        <div class="page-content">


            {{-- =================================================
                                TITRE
            ================================================== --}}

            <div class="page-title">

                <div>

                    <h2>
                        Gestion des utilisateurs
                    </h2>

                    <p>
                        Gérez les comptes utilisateurs et leurs droits d'accès.
                    </p>

                </div>


                <a
                    href="{{ route('utilisateurs.create') }}"
                    class="btn-add"
                >

                    <i class="bi bi-plus-circle"></i>

                    Ajouter un utilisateur

                </a>

            </div>


            {{-- =================================================
                            ALERTES
            ================================================== --}}

            @if(session('success'))

                <div class="alert alert-success">

                    <i class="bi bi-check-circle me-2"></i>

                    {{ session('success') }}

                </div>

            @endif


            @if(session('error'))

                <div class="alert alert-danger">

                    <i class="bi bi-exclamation-circle me-2"></i>

                    {{ session('error') }}

                </div>

            @endif


            {{-- =================================================
                            CARTES
            ================================================== --}}

            <div class="cards">


                {{-- TOTAL --}}

                <div class="card-item">

                    <div class="icon blue">

                        <i class="bi bi-people-fill"></i>

                    </div>

                    <div>

                        <h5>
                            Total utilisateurs
                        </h5>

                        <h2>
                            {{ $totalUtilisateurs }}
                        </h2>

                    </div>

                </div>


                {{-- ACTIFS --}}

                <div class="card-item">

                    <div class="icon green">

                        <i class="bi bi-person-check-fill"></i>

                    </div>

                    <div>

                        <h5>
                            Actifs
                        </h5>

                        <h2>
                            {{ $totalActifs }}
                        </h2>

                    </div>

                </div>


                {{-- INACTIFS --}}

                <div class="card-item">

                    <div class="icon orange">

                        <i class="bi bi-person-x-fill"></i>

                    </div>

                    <div>

                        <h5>
                            Inactifs
                        </h5>

                        <h2>
                            {{ $totalInactifs }}
                        </h2>

                    </div>

                </div>


                {{-- ADMINISTRATEURS --}}

                <div class="card-item">

                    <div class="icon purple">

                        <i class="bi bi-shield-lock-fill"></i>

                    </div>

                    <div>

                        <h5>
                            Administrateurs
                        </h5>

                        <h2>
                            {{ $totalAdministrateurs }}
                        </h2>

                    </div>

                </div>

            </div>


            {{-- =================================================
                                TABLEAU
            ================================================== --}}

            <div class="table-card">

                <div class="table-responsive">

                    <table
                        class="table align-middle"
                        id="usersTable"
                    >

                        <thead>

                            <tr>

                                <th>
                                    Nom
                                </th>

                                <th>
                                    Prénom
                                </th>

                                <th>
                                    Login
                                </th>

                                <th>
                                    Email
                                </th>

                                <th>
                                    Profil
                                </th>

                                <th>
                                    Statut
                                </th>

                                <th width="150">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($utilisateurs as $user)

                                <tr>


                                    {{-- NOM --}}

                                    <td>
                                        {{ $user->nom }}
                                    </td>


                                    {{-- PRENOM --}}

                                    <td>
                                        {{ $user->prenom }}
                                    </td>


                                    {{-- LOGIN --}}

                                    <td>
                                        {{ $user->login }}
                                    </td>


                                    {{-- EMAIL --}}

                                    <td>
                                        {{ $user->email }}
                                    </td>


                                    {{-- PROFIL --}}

                                    <td>

                                        @php

                                            $profil = '';
                                            $class = 'badge-consult';

                                            switch($user->id_profil) {

                                                case 1:

                                                    $profil = 'Administrateur';
                                                    $class = 'badge-admin';

                                                    break;

                                                case 2:

                                                    $profil = 'RH';
                                                    $class = 'badge-rh';

                                                    break;

                                                case 3:

                                                    $profil = 'Commission';
                                                    $class = 'badge-commission';

                                                    break;

                                                case 4:

                                                    $profil = 'Consultation';
                                                    $class = 'badge-consult';

                                                    break;

                                                case 5:

                                                    $profil = 'Responsable de service';
                                                    $class = 'badge-resp';

                                                    break;

                                                default:

                                                    $profil = 'Non défini';

                                                    break;
                                            }

                                        @endphp


                                        <span class="badge {{ $class }}">

                                            {{ $profil }}

                                        </span>

                                    </td>


                                    {{-- STATUT --}}

                                    <td
                                        data-status="{{ $user->actif ? 'actif' : 'inactif' }}"
                                    >

                                        @if($user->actif)

                                            <span class="badge badge-active">

                                                <i class="bi bi-circle-fill"></i>

                                                Actif

                                            </span>

                                        @else

                                            <span class="badge badge-inactive">

                                                <i class="bi bi-circle-fill"></i>

                                                Inactif

                                            </span>

                                        @endif

                                    </td>


                                    {{-- ACTIONS --}}

                                    <td>

                                        <div class="actions">


                                            {{-- VOIR --}}

                                            <a
                                                href="{{ route('utilisateurs.show', $user->id_utilisateur) }}"
                                                class="btn-action btn-view"
                                                title="Voir"
                                            >

                                                <i class="bi bi-eye-fill"></i>

                                            </a>


                                            {{-- MODIFIER --}}

                                            <a
                                                href="{{ route('utilisateurs.edit', $user->id_utilisateur) }}"
                                                class="btn-action btn-edit"
                                                title="Modifier"
                                            >

                                                <i class="bi bi-pencil-square"></i>

                                            </a>


                                            {{-- SUPPRIMER --}}

                                            <form
                                                action="{{ route('utilisateurs.destroy', $user->id_utilisateur) }}"
                                                method="POST"
                                                style="display:inline;"
                                            >

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn-action btn-delete"
                                                    title="Supprimer"
                                                    onclick="return confirm('Supprimer cet utilisateur ?')"
                                                >

                                                    <i class="bi bi-trash-fill"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td
                                        colspan="7"
                                        class="text-center py-5"
                                    >

                                        <i class="bi bi-people fs-1 text-secondary"></i>

                                        <br>

                                        <span class="text-secondary">

                                            Aucun utilisateur trouvé.

                                        </span>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- PAGINATION --}}

                @if($utilisateurs->hasPages())

                    <div>

                        {{ $utilisateurs->links() }}

                    </div>

                @endif

            </div>

        </div>

    </main>


    <!-- Bootstrap JS -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>


    <script>

        document.addEventListener('DOMContentLoaded', function () {


            /* =====================================================
                            ELEMENTS
            ===================================================== */

            const notificationButton =
                document.getElementById('notificationButton');

            const notificationPanel =
                document.getElementById('notificationPanel');

            const userMenuButton =
                document.getElementById('userMenuButton');

            const userMenuPanel =
                document.getElementById('userMenuPanel');

            const searchInput =
                document.getElementById('searchUser');

            const profilFilter =
                document.getElementById('profilFilter');

            const statutFilter =
                document.getElementById('statutFilter');

            const table =
                document.getElementById('usersTable');


            /* =====================================================
                            NOTIFICATIONS
            ===================================================== */

            if (
                notificationButton &&
                notificationPanel
            ) {

                notificationButton.addEventListener(
                    'click',
                    function(event) {

                        event.preventDefault();

                        event.stopPropagation();


                        if (userMenuPanel) {

                            userMenuPanel.classList.remove('active');

                        }

                        notificationPanel.classList.toggle('active');

                    }
                );

            }


            /* =====================================================
                            MENU UTILISATEUR
            ===================================================== */

            if (
                userMenuButton &&
                userMenuPanel
            ) {

                userMenuButton.addEventListener(
                    'click',
                    function(event) {

                        event.preventDefault();

                        event.stopPropagation();


                        if (notificationPanel) {

                            notificationPanel.classList.remove('active');

                        }

                        userMenuPanel.classList.toggle('active');

                    }
                );

            }


            /* =====================================================
                            PROPAGATION
            ===================================================== */

            if (notificationPanel) {

                notificationPanel.addEventListener(
                    'click',
                    function(event) {

                        event.stopPropagation();

                    }
                );

            }


            if (userMenuPanel) {

                userMenuPanel.addEventListener(
                    'click',
                    function(event) {

                        event.stopPropagation();

                    }
                );

            }


            /* =====================================================
                            CLIC EXTERIEUR
            ===================================================== */

            document.addEventListener(
                'click',
                function(event) {


                    if (
                        notificationPanel &&
                        notificationButton &&
                        !notificationPanel.contains(event.target) &&
                        !notificationButton.contains(event.target)
                    ) {

                        notificationPanel.classList.remove('active');

                    }


                    if (
                        userMenuPanel &&
                        userMenuButton &&
                        !userMenuPanel.contains(event.target) &&
                        !userMenuButton.contains(event.target)
                    ) {

                        userMenuPanel.classList.remove('active');

                    }

                }
            );


            /* =====================================================
                                ESC
            ===================================================== */

            document.addEventListener(
                'keydown',
                function(event) {

                    if (event.key === 'Escape') {

                        if (notificationPanel) {

                            notificationPanel.classList.remove('active');

                        }

                        if (userMenuPanel) {

                            userMenuPanel.classList.remove('active');

                        }

                    }

                }
            );


            /* =====================================================
                            FILTRE TABLEAU
            ===================================================== */

            function filtrerTable() {

                if (!table) {
                    return;
                }


                const recherche =
                    searchInput
                        ? searchInput.value
                            .toLowerCase()
                            .trim()
                        : '';


                const profil =
                    profilFilter
                        ? profilFilter.value
                            .toLowerCase()
                            .trim()
                        : '';


                const statut =
                    statutFilter
                        ? statutFilter.value
                            .toLowerCase()
                            .trim()
                        : '';


                const lignes =
                    table.querySelectorAll(
                        'tbody tr'
                    );


                lignes.forEach(
                    function(ligne) {


                        if (ligne.cells.length < 7) {

                            return;

                        }


                        const texte =
                            ligne.innerText
                                .toLowerCase();


                        const profilCell =
                            ligne.cells[4]
                                ? ligne.cells[4]
                                    .innerText
                                    .toLowerCase()
                                    .trim()
                                : '';


                        const statutCell =
                            ligne.cells[5]
                                ? ligne.cells[5]
                                    .getAttribute(
                                        'data-status'
                                    )
                                : '';


                        const rechercheOK =
                            recherche === '' ||
                            texte.includes(recherche);


                        const profilOK =
                            profil === '' ||
                            profilCell.includes(profil);


                        const statutOK =
                            statut === '' ||
                            statutCell === statut;


                        ligne.style.display =
                            rechercheOK &&
                            profilOK &&
                            statutOK
                                ? ''
                                : 'none';

                    }
                );

            }


            /* =====================================================
                            EVENTS FILTRES
            ===================================================== */

            if (searchInput) {

                searchInput.addEventListener(
                    'input',
                    filtrerTable
                );

            }


            if (profilFilter) {

                profilFilter.addEventListener(
                    'change',
                    filtrerTable
                );

            }


            if (statutFilter) {

                statutFilter.addEventListener(
                    'change',
                    filtrerTable
                );

            }


            /* =====================================================
                            INITIALISATION
            ===================================================== */

            filtrerTable();

        });

    </script>

</body>

</html>



