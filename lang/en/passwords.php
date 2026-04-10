<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Password Reset Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are the default lines which match reasons
    | that are given by the password broker for a password update attempt
    | outcome such as failure due to an invalid password / reset token.
    |
     */

    'reset' => d_trans('Your password has been reset.'),
    'sent' => d_trans('We have emailed your password reset link.'),
    'throttled' => d_trans('Please wait before retrying.'),
    'token' => d_trans('This password reset token is invalid.'),
    'user' => d_trans("We can't find a user with that email address."),

];
