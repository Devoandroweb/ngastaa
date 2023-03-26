<?php

namespace App\Repositories\Password;

use LaravelEasyRepository\Repository;

interface PasswordRepository extends Repository{

    // Write something awesome :)
    function changePassword($auth);
}
