<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('organization.index', [
            'title' => 'Organization',
            'organization'=>Organization::latest()->get(),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('organization.create', [
            'title' => 'Create Organization',
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'name' => 'required|max:255',
        'leader_name' => 'required|max:255',
    ], [
        'name.required' => 'Nama Organisasi Tidak Boleh Kosong',
        'name.max' => 'Nama Organisasi Tidak Boleh Lebih Dari :max karakter',
        'leader_name.required' => 'Nama Pimpinan Organisasi Tidak Boleh Kosong',
        'leader_name.max' => 'Nama Pimpinan Organisasi Tidak Boleh Lebih Dari :max karakter',
    ]);


        try{
            DB::beginTransaction();
            $organization = Organization::create($validated);
            $organization ->organizationLeader()->create($validated);
            DB::commit();
            return to_route('organization.index')->withSuccess('Data Berhasil Ditambahkan');   
        } catch(\Exception $e){
            DB::rollBack();
            return to_route('organization.create')->withError('Data gagal Ditambahkan');   
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organization $organization)
    {
        return view('organization.edit', [
            'title' => 'Edit Organization',
            'organization' => $organization,
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Organization $organization)
    {
        $validated = $request->validate([
        'name' => 'required|max:255',
        'leader_name' => 'required|max:255',
    ], [
        'name.required' => 'Nama Organisasi Tidak Boleh Kosong',
        'name.max' => 'Nama Organisasi Tidak Boleh Lebih Dari :max karakter',
        'leader_name.required' => 'Nama Pimpinan Organisasi Tidak Boleh Kosong',
        'leader_name.max' => 'Nama Pimpinan Organisasi Tidak Boleh Lebih Dari :max karakter',
    ]);


        try{
            DB::beginTransaction();
            $organization ->update($validated);
            $organization ->organizationLeader()->updateOrCreate(
                ['organization_id' => $organization->id],
                ['leader_name' => $validated['leader_name']],
            );
            DB::commit();
            return to_route('organization.index')->withSuccess('Data Berhasil Ditambahkan');   
        } catch(\Exception $e){
            DB::rollBack();
            return to_route('organization.edit', $organization)->withError('Data gagal Diedit');   
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization)
    {
        $organization->delete($organization);
        return to_route('organization.index')->withSuccess('Data Berhasil dihapus'); 
    }
}
