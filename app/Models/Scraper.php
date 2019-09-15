<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scraper extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pi_folio',
        'pi_property_address',
        'pi_owner',
        'pi_mail_address',
        'pi_primary_zone',
        'pi_primary_land_use',
        'pi_bed_bath_half',
        'pi_living_area',
        'pi_year_built',
        'assessment_info',
        'full_legal_description',
        'sales_info'
    ];
}
