<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HospitalController extends Controller
{
    public function index(Request $request) {
        $query = Hospital::query();
        if ($request->filled('search')) {
            $search = $request->input('search');
            $cleanedSearch = preg_replace('/[+\-><\(\)~*\"@]/', ' ', $search);
            $words = array_filter(explode(' ', $cleanedSearch));
            $booleanSearch = '';
            foreach ($words as $word) {
                $booleanSearch .= "{$word}* "; 
            }
            $booleanSearch = trim($booleanSearch);
            if (!empty($booleanSearch)) {
                $query->whereFullText(['name', 'full_name'], $booleanSearch, ['mode' => 'boolean']);
            } else {
                $query->orderBy('name', 'asc');
            }
        } else {
            $query->orderBy('name', 'asc');
        }

        $hospitals = $query->paginate(14)->withQueryString();
        
        return Inertia::render('hospitals/Index', [
            'hospitals' => $hospitals,
            'filters' => $request->only(['search']),
        ]);
    }
}
