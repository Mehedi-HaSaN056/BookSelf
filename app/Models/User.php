<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;
    protected $fillable = ['name','email','password','wallet_balance','role'];
    protected $hidden   = ['password','remember_token'];
    protected $casts    = ['password'=>'hashed', 'wallet_balance'=>'decimal:2'];
    public function payments() { return $this->hasMany(Payment::class); }
    public function isAdmin()  { return $this->role === 'admin'; }
    public function isVendor() { return $this->role === 'vendor'; }
}