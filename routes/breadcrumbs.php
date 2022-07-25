<?php

Breadcrumbs::for('home', function($trail){
    $trail->push('Tablero',route('directivo'));
});

Breadcrumbs::for('profesor', function($trail){
    $trail->parent('home');
    $trail->push('Gestión de profesores',route('profesor'));
});