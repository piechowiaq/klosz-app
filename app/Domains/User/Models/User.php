<?php

namespace App\Domains\User\Models;


use App\Domains\Company\Models\Company;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Domains\User\Models\User
 *
 * @property integer $id
 * @property string $name
 * @property string $last_name
 * @property string $email
 * @property Carbon $email_verified_at
 * @property string $phone
 * @property integer $password
 * @property string $remember_token
 * @property integer $current_team_id
 * @property string $profile_photo_path
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $two_factor_secret
 * @property string $two_factor_recovery_codes
 *
 * @property Permission[]|Collection $permissions
 * @property Role[]|Collection $roles
 *
 */

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasRoles;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;
    use ResolveRouteBinding;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function companies(): Relation
    {
        return $this->belongsToMany(Company::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->roles()->where('name', 'Super Admin')->exists();
    }

    public function isBartosz(): bool
    {
        return $this->name == 'Bartosz';
    }

}
