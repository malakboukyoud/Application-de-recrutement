<style>
    /* ===========================
        TOPBAR
=========================== */

.topbar{

    height:70px;

    width:100%;

    background:#fff;

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:0 30px;

    border-bottom:1px solid var(--border);

    position:fixed;

    top:0;

    left:0;

    right:0;

    z-index:1100;
    
}
.topbar-left{

    display:flex;

    align-items:center;

    

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

    color:var(--green);

    margin:0;

    font-size:16px;

    font-weight:600;

}

.user{

    display:flex;

    align-items:center;

    gap:15px;

}

.avatar{

    width:42px;

    height:42px;

    border-radius:50%;

    background:var(--blue);

    color:#fff;

    display:flex;

    align-items:center;

    justify-content:center;

    font-weight:bold;

}
:root {

    /* Couleurs principales ORMVASM */
    --green: #15803D;
    --green-dark: #166534;
    --green-light: #DCFCE7;


    /* Couleurs secondaires */
    --blue: #2563EB;
    --blue-light: #DBEAFE;


    /* Arrière-plans */
    --background: #F8FAFC;
    --white: #FFFFFF;


    /* Texte */
    --text-dark: #1F2937;
    --text-gray: #64748B;


    /* Bordures */
    --border: #E5E7EB;


    /* Ombres */
    --shadow: 0 10px 30px rgba(0,0,0,0.08);

}
</style>
<div class="topbar"> 
    <div class="topbar-left">
         <img src="{{ asset('image/ormvaa.png') }}" class="topbar-logo"> 
         <h5> Office Régional de Mise en Valeur Agricole du Souss Massa </h5> 
    </div>
    <div class="user">
         <i class="bi bi-bell fs-5"></i> <div class="avatar"> RH </div> 
    </div>
 </div>
@extends('layouts.app')
@section('title', 'Nouveau candidat')
@include('layouts.topbar')
@section('content')
    <h3 class="mb-3">Nouveau candidat</h3>
    <div class="card p-4">
        <form method="POST" action="{{ route('candidats.store') }}">
            @csrf
            @include('candidats._form')
        </form>
    </div>
@endsection
