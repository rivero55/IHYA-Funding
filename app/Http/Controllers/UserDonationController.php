<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\UserDonation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $user_donations= Transaction::where('user_id', $user_id)->get();
        return view('transaction.user-donation')->with(compact('user_donations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserDonation  $userDonation
     * @return \Illuminate\Http\Response
     */
    public function show(UserDonation $userDonation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserDonation  $userDonation
     * @return \Illuminate\Http\Response
     */
    public function edit(UserDonation $userDonation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserDonation  $userDonation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserDonation $userDonation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserDonation  $userDonation
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserDonation $userDonation)
    {
        //
    }
}
