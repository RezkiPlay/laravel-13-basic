<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use Illuminate\Http\Request;
use App\Models\Department;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lecturer.index', [
            'title' => 'Lecturer',
            'lecturers'=>Lecturer::latest()->get(),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('lecturer.create', [
            'title' => 'Create Lecturer',
            'departments'=>Department::latest()->get(),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'name' => 'required|max:255',
        'department_id' => 'required|exists:departments,id',
    ], [
        'name.required' => 'Nama Tidak Boleh Kosong',
        'name.max' => 'Nama Tidak Boleh Lebih Dari :max karakter',
        'department_id.required' => 'Program Studi Tidak Boleh Kosong',
        'department_id.exists' => 'Programs studi yang dipilih tidak di temukan',
    ]);

        Lecturer::create($validated);
        return to_route('lecturer.index')->withSuccess('Data Berhasil Ditambahkan');   
    }

    /**
     * Display the specified resource.
     */
    public function show(Lecturer $lecturer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lecturer $lecturer)
    {
        return view('lecturer.edit', [
            'title' => 'Edit Lecturer',
            'departments'=>Department::latest()->get(),
            'lecturer'=> $lecturer,
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lecturer $lecturer)
    {
        $validated = $request->validate([
        'name' => 'required|max:255',
        'department_id' => 'required|exists:departments,id',
    ], [
        'name.required' => 'Nama Tidak Boleh Kosong',
        'name.max' => 'Nama Tidak Boleh Lebih Dari :max karakter',
        'department_id.required' => 'Program Studi Tidak Boleh Kosong',
        'department_id.exists' => 'Programs studi yang dipilih tidak di temukan',
    ]);

        $lecturer->update($validated);
        return to_route('lecturer.index')->withSuccess('Data Berhasil Diubah');  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lecturer $lecturer)
    {
        $lecturer->delete($lecturer);
        return to_route('lecturer.index')->withSuccess('Data Berhasil dihapus'); 
    }
}
