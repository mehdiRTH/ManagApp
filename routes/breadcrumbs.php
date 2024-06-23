<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.

use App\Models\Meeting;
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});


// All Users
Breadcrumbs::for('users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('All Users', route('users.index'));
});

// User Create
Breadcrumbs::for('users.create', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('All Users', route('users.index'));
    $trail->push('Create User', route('users.create'));
});

// user Edit
Breadcrumbs::for('users.edit', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('dashboard');
    $trail->push('All Users', route('users.index'));
    $trail->push('update '.$user->name, route('users.update', $user));
});


//////////////////////////////////// Sections \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

Breadcrumbs::for('sections.index', function (BreadcrumbTrail $trail){
    $trail->parent('dashboard');
    $trail->push('All Sections', route('sections.index'));
});

Breadcrumbs::for('sections.create', function (BreadcrumbTrail $trail){
    $trail->parent('dashboard');
    $trail->push('All Sections', route('sections.index'));
    $trail->push('Create Section', route('sections.create'));
});


Breadcrumbs::for('sections.edit', function (BreadcrumbTrail $trail, $section){
    $trail->parent('dashboard');
    $trail->push('All Sections', route('sections.index'));
    $trail->push('Edit Section '.$section->name, route('sections.edit',$section));
});

//////////////////////////////////// Meetings \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

Breadcrumbs::for('meetings.index', function (BreadcrumbTrail $trail){
    $trail->parent('dashboard');
    $trail->push('All Meetings', route('meetings.index'));
});

Breadcrumbs::for('meetings.create', function (BreadcrumbTrail $trail){
    $trail->parent('dashboard');
    $trail->push('All Meetings', route('meetings.index'));
    $trail->push('Create Meeting', route('meetings.create'));
});

Breadcrumbs::for('meetings.edit', function (BreadcrumbTrail $trail,Meeting $meeting){
    $trail->parent('dashboard');
    $trail->push('All Meetings', route('meetings.index'));
    $trail->push('edit Meeting', route('meetings.edit', $meeting));
});

Breadcrumbs::for('meetings.show', function (BreadcrumbTrail $trail,Meeting $meeting){
    $trail->parent('dashboard');
    $trail->push('All Meetings', route('meetings.index'));
    $trail->push('Meeting Information', route('meetings.show', $meeting));
});
