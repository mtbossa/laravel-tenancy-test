<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('test.{testId}', function ($user, $testId) {
    return true;
});

Broadcast::channel('test2.{testId}', function ($user, $testId) {
    return false;
});

Broadcast::channel('test3.{tenantId}', function ($user, string $tenantId) {
    $currentTenant = tenant();

    return $currentTenant->id === $tenantId;
});

Broadcast::channel('test4', function ($user) {
    $isTenant = (bool) tenant();
    return !$isTenant;
});
