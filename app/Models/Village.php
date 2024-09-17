<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $commune_id
 */
class Village extends Model
{
    protected $table = 'sys_villages';
    protected $primaryKey = 'vil_code';

    public $incrementing = false;
    public $timestamps = false;

    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    protected $fillable = ['vil_code', 'com_code', 'name_en', 'name_kh', 'note'];
    
    /**
     * Get the commune
     */
    public function commune()
    {
        return $this->belongsTo(Commune::class, 'com_code');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function residencemembers()
    {
		return $this->hasMany('App\Models\Residencemember');
       
    }
    
}
