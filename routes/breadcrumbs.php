<?php

Breadcrumbs::for('home', function($trail){
    $trail->push('Tablero',route('directivo'));
});

Breadcrumbs::for('profesor', function($trail){
    $trail->parent('home');
    $trail->push('Gestión de profesores',route('profesor'));
});

Breadcrumbs::for('materia', function($trail){
    $trail->parent('home');
    $trail->push('Gestión de materias',route('materia'));
});

Breadcrumbs::for('grupo', function($trail){
    $trail->parent('home');
    $trail->push('Gestión de grupos',route('grupo'));
});

Breadcrumbs::for('alumnos', function($trail){
    $trail->parent('home');
    $trail->push('Gestión de alumnos',route('alumnos'));
});