@extends('backend.master')
@section('content')
<div class="admin-container">
    <section class="admin-left">@include('/backend.partials.adminMenu')</section>
    <section class="admin-right">
        <ul>
            <li class="adding-title"><h3>Banner</h3></li>
            <li class="adding-title"><h3>Kategoriler</h3></li>
            <li class="adding-title"><h3>Projeler</h3></li>
            <li class="adding-title"><h3>Etkinlikler</h3></li>
        </ul>
    </section>
</div>
@stop