<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject {

    use Notifiable;
    private $roles;
    private $firstname;
    private $email;
    private $status;
    private $lastname;

    function getFirstname() {
        return $this->firstname;
    }

    function getEmail() {
        return $this->email;
    }

    function getStatus() {
        return $this->status;
    }

    function getLastname() {
        return $this->lastname;
    }

    function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setRoles($roles) {
        $this->roles = $roles;
    }

    protected $fillable = [
        'firstname',
        'email',
        'status',
        'ultimonome',
    ];
    protected $hidden = [
        'remember_token',
        'password'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

}
