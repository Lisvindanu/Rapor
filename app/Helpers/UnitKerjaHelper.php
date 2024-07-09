<?php

namespace App\Helpers;

use App\Models\UnitKerja;

class UnitKerjaHelper
{
    public static function getUnitKerjaIds()
    {
        $selectedUnitKerjaId = session('selected_filter');
        $datafilter = UnitKerja::with('childUnit')->where('id', $selectedUnitKerjaId)->get();
        $unitKerjaIds = $datafilter->pluck('id')->toArray();
        foreach ($datafilter as $unitKerja) {
            $unitKerjaIds = array_merge($unitKerjaIds, $unitKerja->childUnit->pluck('id')->toArray());
        }
        return $unitKerjaIds;
    }

    public static function getUnitKerja()
    {
        // jika tidak memiliki session role maka redirect ke gate
        // if (!session('selected_filter') && !session('role')) {
        // return redirect()->route('gate');
        // }

        $selectedUnitKerjaId = session('selected_filter');
        $datafilter = UnitKerja::with('childUnit')->where('id', $selectedUnitKerjaId)->get();
        return $datafilter;
    }
}
