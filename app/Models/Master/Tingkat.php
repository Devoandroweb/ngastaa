<?php

namespace App\Models\Master;

use App\Models\MRoleMenu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tingkat extends Model
{
    use HasFactory;

    protected $table = 'tingkat';

    protected $guarded = [];

    protected $appends = [
        'parents',
    ];

    function skpd(){
        return $this->hasOne(Skpd::class,'kode_skpd','kode_skpd');
    }
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'kode_tingkat');
    }

    public function children()
    {
        return $this->hasMany(self::class,  'parent_id', 'kode_tingkat');
    }

    public function eselon()
    {
        return $this->belongsTo(Eselon::class, 'kode_eselon', 'kode_eselon');
    }
    function roleMenu(){
        return $this->hasMany(MRoleMenu::class,'kode_tingkat','kode_tingkat');
    }
    public function getParentsAttribute()
    {
        $parents = collect([]);

        $parent = $this->parent;

        while (!is_null($parent)) {
            $parents->push($parent);
            $parent = $parent->parent;
        }

        return $parents;
    }
}
