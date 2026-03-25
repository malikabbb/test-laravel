<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $search = $request->get('search');
        
        $query = Member::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($status && in_array($status, ['Active', 'Pending', 'Expired'])) {
            $query->where('status', $status);
        }

        $members = $query->orderBy('id', 'desc')->paginate(10);
        
        return view('members', compact('members', 'status', 'search'));
    }

    public function store(StoreMemberRequest $request)
    {
        Member::create($request->validated());
        return redirect()->route('members.index')->with('success', 'Member added successfully via FitPro System.');
    }

    public function update(UpdateMemberRequest $request, Member $member)
    {
        $member->update($request->validated());
        return redirect()->route('members.index')->with('success', 'Member details modernized & updated.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Member correctly expunged from directory.');
    }
}
