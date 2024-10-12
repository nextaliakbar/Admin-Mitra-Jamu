<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backoffice\Member\StoreMemberRequest;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::orderBy('id', 'DESC')->get();

        return view('pages._Main.MasterData.Member.index', compact('members'));
    }

    public function store(StoreMemberRequest $request)
    {
        $member = Member::create([
            'name' => $request->name ?? null,
            'email' => $request->email ?? null,
            'phone' => $request->phone ?? null,
            'address' => $request->address ?? null,

        ]);

        if (!$member) {
            return responseToast('error', 'Something went wrong', null, 500);
        }

        return responseToast('success', 'Member created successfully');
    }

    public function edit(Member $member)
    {
        return response()->json([
            'status' => true,
            'data' => $member,
        ]);
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $member->update([
            'name' => $request->name ?? null,
            'email' => $request->email ?? null,
            'phone' => $request->phone ?? null,
            'address' => $request->address ?? null,
        ]);

        if (!$member) {
            return responseToast('error', 'Something went wrong', null, 500);
        }
        return responseToast('success', 'Member updated successfully');
    }

    public function destroy(Member $member)
    {
        $member->delete();

        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
                'title' => 'Error!'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Member deleted successfully',
            'title' => 'Success.',
        ]);
    }
}
