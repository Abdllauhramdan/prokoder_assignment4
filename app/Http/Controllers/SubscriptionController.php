<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller{
    public function create()
    {
        return view('subscriptions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'plan' => 'required|string',
            'start_date' => 'required|date',
        ]);

        Subscription::create([
            'member_id' => $request->member_id,
            'plan' => $request->plan,
            'start_date' => $request->start_date,
        ]);

        return redirect()->route('subscriptions.create')->with('success', 'Subscription created successfully.');
    }

    public function index()
    {
        $subscriptions = Subscription::all();
        return view('subscriptions.index', compact('subscriptions'));
    }

    public function show($id)
    {
        $subscription = Subscription::findOrFail($id);
        return view('subscriptions.show', compact('subscription'));
    }

    public function edit($id)
    {
        $subscription = Subscription::findOrFail($id);
        return view('subscriptions.edit', compact('subscription'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'plan' => 'required|string',
            'start_date' => 'required|date',
        ]);

        $subscription = Subscription::findOrFail($id);
        $subscription->update([
            'member_id' => $request->member_id,
            'plan' => $request->plan,
            'start_date' => $request->start_date,
        ]);

        return redirect()->route('subscriptions.index')->with('success', 'Subscription updated successfully.');
    }

    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();

        return redirect()->route('subscriptions.index')->with('success', 'Subscription deleted successfully.');
    }
}