<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LocationController extends Controller
{
    /**
     * Get all districts and blocks from the JSON file.
     */
    public function getLocations()
    {
        $path = storage_path('app/up_locations.json');

        if (!file_exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $json = file_get_contents($path);
        return response()->json(json_decode($json, true));
    }

    /**
     * Get only the list of districts.
     */
    public function getDistricts()
    {
        $json = Storage::get('up_locations.json');
        $data = json_decode($json, true);
        return response()->json(array_keys($data));
    }

    /**
     * Get blocks for a specific district.
     */
    public function getBlocks($district)
    {
        $json = Storage::get('up_locations.json');
        $data = json_decode($json, true);

        if (isset($data[$district])) {
            return response()->json($data[$district]);
        }

        return response()->json([], 404);
    }
}
