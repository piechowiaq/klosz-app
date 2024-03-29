<?php

namespace App\Domains\Company\Models;

use App\Domains\User\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Collection\Collection;

/**
 * App\Vendor\Spatie\Laravel-permission\Src\Models\Permission
 *
 * @property integer $id
 * @property string $name
 * @property string $city
 * @property string $email
 * @property string $phone
 *
 */

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;
    use ResolveRouteBinding;

    /** @var array|string[] */
    protected $guarded = [];

    public function users(): Relation
    {
        return $this->belongsToMany(User::class);
    }

    public function registries(): Relation
    {
        return $this->belongsToMany(Registry::class)->withPivot('assigned');;
    }

    public function reports(): Relation
    {
        return $this->hasMany(Report::class);
    }

    public function reportsByIds(): \Illuminate\Support\Collection
    {

        return $this->reports()->get(['registry_id']);
    }

    public function expiredReports(): \Illuminate\Support\Collection
    {

        return $this->reports()->whereDate('expiry_date', '<', Carbon::now())->get('registry_id');
    }

}
