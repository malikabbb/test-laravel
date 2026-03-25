<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;

class MemberController extends Controller
{
    public function index()
    {
        return response()->json(Member::orderBy('id', 'desc')->paginate(10));
    }

    public function store(StoreMemberRequest $request)
    {
        $member = Member::create($request->validated());
        return response()->json($member, 201);
    }

    public function show(Member $member)
    {
        return response()->json($member);
    }

    public function update(UpdateMemberRequest $request, Member $member)
    {         
        $member->update($request->validated());
        return response()->json($member);
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return response()->json(null, 204);
    }
}
