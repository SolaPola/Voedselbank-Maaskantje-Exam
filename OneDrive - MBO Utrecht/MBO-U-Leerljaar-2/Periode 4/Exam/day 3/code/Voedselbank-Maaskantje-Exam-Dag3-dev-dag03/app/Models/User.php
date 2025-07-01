<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'login_name',
        'name',
        'email',
        'password',
        'person_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'logged_in_at' => 'datetime',
            'logged_out_at' => 'datetime',
        ];
    }

    /**
     * Get the roles for the user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_per_users');
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole(string $roleName): bool
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    /**
     * Get redirect path based on user role.
     */
    public function getRedirectPath(): string
    {
        $roleIds = $this->roles->pluck('id')->toArray();

        if (in_array(1, $roleIds)) {
            return '/manager/dashboard';
        } elseif (in_array(2, $roleIds)) {
            return '/employee/dashboard';
        } elseif (in_array(3, $roleIds)) {
            return '/volunteer/dashboard';
        }

        return '/dashboard';
    }
}
