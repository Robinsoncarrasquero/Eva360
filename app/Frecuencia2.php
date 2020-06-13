<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Frecuencia2 extends Model
{
   /**
   * Users' roles
   *
   * @var array
   */
  protected $fillable=['frecuencia_id'];
  private const ROLES = [
      1 => 'frecuente',
      2 => 'siempre',
      3 => 'medio',
      4 => 'ocacional',
   ];
   /**
   * returns the id of a given role
   *
   * @param string $role  user's role
   * @return int roleID
   */
   public static function getFrecuenciaID($frecuencia)
   {
      return array_search($frecuencia, self::ROLES);
   }
   /**
   * get user role
   */
   public function getFrecuenciaAttribute()
   {
      return self::ROLES[ $this->attributes['frecuencia_id'] ];
   }
   /**
   * set user role
   */
   public function setRoleAttribute($value)
   {
      $ID = self::getFrecuenciaID($value);
      if ($ID) {
         $this->attributes['frecuencia_id'] = $ID;
      }
   }
}
