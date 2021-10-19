<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordClass;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Password;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements CanResetPasswordClass
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;
    use CanResetPassword;

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

    public function searchable()
    {
        return [
            'userDetail_full_name',
        ];
    }

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

    public function sendPasswordResetNotification($token, $spielCode = null)
    {
        $params = http_build_query([
            'token' => Password::getRepository()->create($this),
            'email' => $this->attributes['email'],
        ]);
        $url = env('WEB_URL')."/auth/reset-password?$params";
        sendGridEmail([
            'subject' => 'Welcome to PCL Legislative Academy',
            'recipient' => $this->email,
            'recipient_name' => $this->userDetail->full_name,
            'content' => 'Welcome to PCL Legislative Academy. You can set your new password in this link <a href="'.$url.'"> Click here</a>',
        ]);
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
