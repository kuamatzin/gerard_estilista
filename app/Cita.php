<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 'citas';

    protected $fillable = ['estilista_id', 'nombre', 'apellidos', 'telefono', 'email', 'fecha_llegada', 'fecha_salida', 'confirmado'];

    protected $dates = ['fecha_llegada', 'fecha_salida'];

    public function estilista()
    {
        return $this->belongsTo(Cabana::class, 'estilista_id');
    }

    public function getFechaLlegadaAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->toFormattedDateString();
    }

    public function getFechaSalidaAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->toFormattedDateString();
    }

    public function getTipoAttribute($value)
    {
        switch ($value) {
            case '1':
                return "Corte de cabello";
                break;
            case '2':
                return "2 habitaciones";
                break;
            case '3':
                return "3 habitaciones";
                break;
            case '4':
                return "Temazcal";
                break;
            default:
                return "Entrada a la sierra";
                break;
        }
    }
}
