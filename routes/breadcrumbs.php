<?php

use App\Models\User;
use App\Models\Plan;
use App\Models\Feature;


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
// Home > Dashboard > User Management
Breadcrumbs::for('user-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('User Management', route('user-management.users.index'));
});

// Home > Dashboard > User Management > Users
Breadcrumbs::for('user-management.users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Users', route('user-management.users.index'));
});

// Home > Dashboard > User Management > Users > [User]
Breadcrumbs::for('user-management.users.show', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('user-management.users.index');
    $trail->push(ucwords($user->name), route('user-management.users.show', $user));
});

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

