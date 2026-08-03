<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HospitalController extends Controller
{
    public function index() {
        return Inertia::render('Hospitals/Index');
        // $query = Hospital::query();

        // // Живой поиск по названию
        // if ($request->filled('search')) {
        //     $query->where('name', 'LIKE', '%' . $request->search . '%')
        //           ->orWhere('full_name', 'LIKE', '%' . $request->search . '%');
        // }

        // return Inertia::render('Hospitals/Index', [
        //     'hospitals' => $query->orderBy('name', 'asc')->paginate(15)->withQueryString(),
        //     'filters' => $request->only(['search']), // Чтобы сохранить текст в инпуте при поиске
        // ]);
    }

    /**
     * Карточка конкретной больницы с её биопсиями.
     */
    // public function show(Hospital $hospital): Response
    // {
    //     return Inertia::render('Hospitals/Show', [
    //         'hospital' => $hospital,
    //         'biopsies' => $hospital->biopsies()
    //             ->with('patient:id,fio') // Берем только нужные поля пациента для скорости
    //             ->orderBy('incoming_date', 'desc')
    //             ->paginate(20),
    //     ]);
    // }

    /**
     * Сохранение новой больницы (через Inertia.form во Vue).
     */
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'full_name' => 'nullable|string',
    //     ]);

    //     Hospital::create($validated);

    //     // Перенаправляем обратно, Inertia автоматически обновит данные на клиенте
    //     return redirect()->route('hospitals.index')->with('success', 'Учреждение успешно добавлено');
    // }
}
