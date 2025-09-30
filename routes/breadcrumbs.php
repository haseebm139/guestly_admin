<?php

use App\Models\User;
use App\Models\Plan;
use App\Models\Feature;
use App\Models\Supply;


use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Spatie\Permission\Models\Role;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('dashboard'));
});

// Home > Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Dashboard', route('dashboard'));
});


// Home > Dashboard > Plan Management
Breadcrumbs::for('plan-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Plan Management', route('plan-management.plans.index'));
});

// Home > Dashboard > Plan Management > Plans
Breadcrumbs::for('plan-management.plans.index', function (BreadcrumbTrail $trail) {
    $trail->parent('plan-management.index');
    $trail->push('Plans', route('plan-management.plans.index'));
});

// Home > Dashboard > Plan Management > Plans > [Plan]
Breadcrumbs::for('plan-management.plans.show', function (BreadcrumbTrail $trail, Plan $plan) {
    $trail->parent('plan-management.plans.index');
    $trail->push(ucwords($plan->name), route('plan-management.plans.show', $plan));
});


// Home > Dashboard > Plan Management > Features
Breadcrumbs::for('plan-management.features.index', function (BreadcrumbTrail $trail) {
    $trail->parent('plan-management.index');
    $trail->push('Features', route('plan-management.features.index'));
});

// Home > Dashboard > Plan Management > Features > [Plan]
Breadcrumbs::for('plan-management.features.show', function (BreadcrumbTrail $trail, Feature $feature) {
    $trail->parent('plan-management.features.index');
    $trail->push(ucwords($feature->name), route('plan-management.features.show', $feature));
});

// Home > Dashboard > Creative  Management
Breadcrumbs::for('creative-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Creative Management', route('creative-management.supplies.index'));
});

// Home > Dashboard > Creative  Management > Supplies
Breadcrumbs::for('creative-management.supplies.index', function (BreadcrumbTrail $trail) {
    $trail->parent('creative-management.index');
    $trail->push('Supplies', route('creative-management.supplies.index'));
});

// Home > Dashboard > Creative  Management > Station Amenities
Breadcrumbs::for('creative-management.station-amenities.index', function (BreadcrumbTrail $trail) {
    $trail->parent('creative-management.index');
    $trail->push('Station Amenities', route('creative-management.station-amenities.index'));
});

// Home > Dashboard > Creative  Management > Tattoo Styles
Breadcrumbs::for('creative-management.tattoo-styles.index', function (BreadcrumbTrail $trail) {
    $trail->parent('creative-management.index');
    $trail->push('Tattoo Styles', route('creative-management.tattoo-styles.index'));
});

// Home > Dashboard > Creative  Management > Design Speciality
Breadcrumbs::for('creative-management.design-specialities.index', function (BreadcrumbTrail $trail) {
    $trail->parent('creative-management.index');
    $trail->push('Design Speciality', route('creative-management.tattoo-styles.index'));
});


// Home > Dashboard > Creative  Management > Supplies > [Plan]
Breadcrumbs::for('creative-management.supplies.show', function (BreadcrumbTrail $trail, Supply $supply) {
    $trail->parent('creative-management.supplies.index');
    $trail->push(ucwords($supply->name), route('creative-management.supplies.show', $supply));
});




// Home > Dashboard > User Management
Breadcrumbs::for('user-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('User Management', route('user-management.artists.index'));
});

 

  
  

// Studio
 
// Home > Dashboard > User Management > Users
Breadcrumbs::for('user-management.studios.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Studios', route('user-management.studios.index'));
});

// Home > Dashboard > User Management > Users > [User]
Breadcrumbs::for('user-management.studios.show', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('user-management.studios.index');
    $trail->push(ucwords($user->name), route('user-management.studios.show', $user));
});

// Studio


// Artists
 
// Home > Dashboard > User Management > Users
Breadcrumbs::for('user-management.artists.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Guest Artists', route('user-management.artists.index'));
});

// Home > Dashboard > User Management > Users > [User]
Breadcrumbs::for('user-management.artists.show', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('user-management.artists.index');
    $trail->push(ucwords($user->name), route('user-management.artists.show', $user));
});

// Artists


// Admin
 
// Home > Dashboard > User Management > Users
Breadcrumbs::for('user-management.administrators.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Administrators', route('user-management.administrators.index'));
});

// Home > Dashboard > User Management > Users > [User]
Breadcrumbs::for('user-management.administrators.show', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('user-management.administrators.index');
    $trail->push(ucwords($user->name), route('user-management.administrators.show', $user));
});

// Admin


// Home > Dashboard > User Management > Roles
Breadcrumbs::for('user-management.roles.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Roles', route('user-management.roles.index'));
});

// Home > Dashboard > User Management > Roles > [Role]
Breadcrumbs::for('user-management.roles.show', function (BreadcrumbTrail $trail, Role $role) {
    $trail->parent('user-management.roles.index');
    $trail->push(ucwords($role->name), route('user-management.roles.show', $role));
});

// Home > Dashboard > User Management > Permission
Breadcrumbs::for('user-management.permissions.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Permissions', route('user-management.permissions.index'));
});

// Home > Product Management
Breadcrumbs::for('product.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Products', route('product.index'));
});

