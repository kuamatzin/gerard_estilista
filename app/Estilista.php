<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estilista extends Model
{
    protected $table = 'estilistas';

    protected $fillable = ['nombre', 'disponibilidad', 'tipo'];

    public function getTipoAttribute($value)
    {
        switch ($value) {
            case '1':
                return "1 habitación";
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

    public function getDisponibilidadAttribute($value)
    {
        return (!$value) ? "Disponible" : "No Disponible";
    }
}
