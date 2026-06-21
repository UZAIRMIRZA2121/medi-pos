<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::where('store_id', Auth::id())->latest()->get();
        return view('expenses.index', compact('expenses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'desc' => 'nullable|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:paid,pending',
        ]);

        $data = $request->except('img');
        $data['store_id'] = Auth::id();

        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->store('expenses', 'public');
        }

        if ($data['status'] === 'paid') {
            $data['paid_at'] = now();
        }

        Expense::create($data);

        return redirect()->route('expenses.index')->with('success', 'Expense created successfully.');
    }

    public function update(Request $request, Expense $expense)
    {
        if ($expense->store_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'desc' => 'nullable|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:paid,pending',
        ]);

        $data = $request->except('img');

        if ($request->hasFile('img')) {
            if ($expense->img) {
                Storage::disk('public')->delete($expense->img);
            }
            $data['img'] = $request->file('img')->store('expenses', 'public');
        }

        if ($data['status'] === 'paid' && $expense->status !== 'paid') {
            $data['paid_at'] = now();
        } elseif ($data['status'] === 'pending') {
            $data['paid_at'] = null;
        }

        $expense->update($data);

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->store_id !== Auth::id()) {
            abort(403);
        }

        if ($expense->img) {
            Storage::disk('public')->delete($expense->img);
        }

        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
