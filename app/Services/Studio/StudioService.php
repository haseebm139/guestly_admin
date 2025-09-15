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
                'tattoo_styles' => TattooStyle::where('status', 1)->get(),
            ];
        }

        // ── Studio or admin: full tables ─────────────────────────────
        return [
            'supplies'           => Supply::where('status', true)->get(),
            'station_amenities'  => StationAmenity::where('status', 1)->get(),
            'design_specialties' => DesignSpecialty::where('status', 1)->get(),

        ];
    }

}
