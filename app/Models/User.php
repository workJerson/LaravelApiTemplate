<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'email',
         'password',
         'account_type',
         'status',
         'login_attempts',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function findForPassport($email)
    {
        return self::where('email', $email)->first();
    }

    /**
     * Increment the login attempts of the user.
     */
    public function incrementLoginAttempts()
    {
        $this->increment('login_attempts');

        if ($this->login_attempts >= 3) {
            $this->deactivate();
        }
    }

    /**
     * Clear the user's number of login attempts.
     */
    public function clearLoginAttempts()
    {
        $this->login_attempts = 0;
        $this->save();
    }

    /**
     * Deactivate the user.
     */
    public function deactivate()
    {
        $this->status = 0;

        $this->save();
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function coordinator()
    {
        return $this->hasOne(Coordinator::class);
    }

    public function cmsProfile()
    {
        return $this->hasOne(CmsProfile::class);
    }

    public function userDetail()
    {
        return $this->hasOne(UserDetail::class);
    }
}
