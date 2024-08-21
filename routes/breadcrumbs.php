<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.

use App\Models\Announce;
use App\Models\DailyActivity;
use App\Models\Meeting;
use App\Models\OffRequest;
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
    if($meeting!=new Meeting()) $trail->push('Meeting Informations', route('meetings.show', $meeting));
    else $trail->push('This Meeting has been Canceled', route('meetings.index'));
});


//////////////////////////////////// Holidays \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

Breadcrumbs::for('holidays.index',function (BreadcrumbTrail $trail){
    $trail->parent('dashboard');
    $trail->push('Holidays',route('holidays.index'));
});

//////////////////////////////////// Anounces \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

Breadcrumbs::for('announces.index',function (BreadcrumbTrail $trail){
    $trail->parent('dashboard');
    $trail->push('Anounces', route('announces.index'));
});

Breadcrumbs::for('announces.create',function (BreadcrumbTrail $trail){
    $trail->parent('dashboard');
    $trail->push('Announces', route('announces.index'));
    $trail->push('Create Anounce', route('announces.create'));
});

Breadcrumbs::for('announces.edit',function (BreadcrumbTrail $trail,Announce $announce){
    $trail->parent('dashboard');
    $trail->push('Announces', route('announces.index'));
    $trail->push('Edit Anounce', route('announces.edit', $announce));
});


//////////////////////////////////// Day Off Request \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


Breadcrumbs::for('off_requests.index',function (BreadcrumbTrail $trail){
    $trail->parent('dashboard');
    $trail->push('Day off Requests', route('off_requests.index'));
});

Breadcrumbs::for('off_requests.create',function (BreadcrumbTrail $trail){
    $trail->parent('dashboard');
    $trail->push('Day off Requests', route('off_requests.index'));
    $trail->push('Create Request', route('off_requests.create'));
});

Breadcrumbs::for('off_requests.edit',function (BreadcrumbTrail $trail, OffRequest $offRequest){
    $trail->parent('dashboard');
    $trail->push('Day off Requests', route('off_requests.index'));
    $trail->push('Edit Request', route('off_requests.edit',$offRequest));
});

Breadcrumbs::for('off_requests.show',function (BreadcrumbTrail $trail, OffRequest $offRequest){
    $trail->parent('dashboard');
    $trail->push('Day off Requests', route('off_requests.index'));
    $trail->push('Show Request Information', route('off_requests.show',$offRequest));
});

//////////////////////////////////// Daily Activities \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

Breadcrumbs::for('daily_activities.index',function (BreadcrumbTrail $trail){
    $trail->parent('dashboard');
    $trail->push('Daily Activities', route('daily_activities.index'));
});

Breadcrumbs::for('daily_activities.show',function (BreadcrumbTrail $trail,DailyActivity $activity){
    $trail->parent('dashboard');
    $trail->push('Daily Activities', route('daily_activities.index'));
    $trail->push('User Activities Information', route('daily_activities.show',$activity));
});

Breadcrumbs::for('daily_activities.read_qr',function (BreadcrumbTrail $trail){
    $trail->parent('dashboard');
    $trail->push('Daily Activities', route('daily_activities.index'));
    $trail->push('Read Entrance QrCode', route('daily_activities.read_qr'));
});
