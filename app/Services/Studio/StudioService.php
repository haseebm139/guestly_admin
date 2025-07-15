<?php
namespace App\Services\Studio;


use App\Models\Supply;
use App\Models\StationAmenity;
use App\Models\DesignSpecialty;
use App\Models\TattooStyle;
use Illuminate\Support\Facades\Auth;
class StudioService
{
    public function lookups(): array
    {
        $user = Auth::user();

        // ── Artist: only tattoo styles ───────────────────────────────
        if ($user?->user_type === 'artist') {
            return [
                'tattoo_styles' => TattooStyle::all(),
            ];
        }

        // ── Studio or admin: full tables ─────────────────────────────
        return [
            'supplies'           => Supply::all(),
            'station_amenities'  => StationAmenity::all(),
            'design_specialties' => DesignSpecialty::all(),

        ];
    }

}
