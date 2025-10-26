<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::paginate(10);
        return view('admin.member.index', compact('members'));
    }


    public function create()
    {
        return view('admin.member.create');
    }

public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|unique:members,email',
        'no_hp' => 'required|string|max:15',
        'alamat' => 'required|string',
    ]);

    Member::create([
        'nama' => $request->nama,
        'email' => $request->email,
        'no_hp' => $request->no_hp,
        'alamat' => $request->alamat,
    ]);

    return redirect()->route('admin.member.index')
        ->with('success', 'Member berhasil ditambahkan');
}



    public function show(Member $member)
    {
        return view('admin.member.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('admin.member.edit', compact('member'));
    }

public function update(Request $request, Member $member)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|unique:members,email,' . $member->id,
        'no_hp' => 'required|string|max:15',
        'alamat' => 'required|string',
    ]);

    $member->update([
        'nama' => $request->nama,
        'email' => $request->email,
        'no_hp' => $request->no_hp,
        'alamat' => $request->alamat,
    ]);

    return redirect()->route('admin.member.index')
        ->with('success', 'Data member berhasil diperbarui');
}

    public function destroy(Member $member)
    {
        $member->update(['status' => 'nonaktif']);

        return redirect()->route('admin.member.index')
            ->with('success', 'Member berhasil dinonaktifkan');
    }
}