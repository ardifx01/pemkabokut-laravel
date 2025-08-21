<?php

namespace App\Http\Controllers\Admin;

use App\Models\Business;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    /**
     * Display a listing of the businesses.
     */
    public function index(Request $request)
    {
        $query = Business::with('user')->latest();
        
        // Filter by status if requested
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        
        $businesses = $query->paginate(10);
        
        return view('admin.businesses.index', compact('businesses'));
    }

    /**
     * Display the specified business.
     */
    public function show(Business $business)
    {
        $business->load('user');
        return view('admin.businesses.show', compact('business'));
    }

    /**
     * Approve a business.
     */
    public function approve(Business $business)
    {
        $business->update([
            'status' => 1,
            'user_id' => Auth::id()
        ]);
        return redirect()->route('admin.businesses.index')
            ->with('success', 'Business approved successfully.');
    }

    /**
     * Reject/unapprove a business.
     */
    public function reject(Business $business)
    {
        $business->update([
            'status' => 0,
            'user_id' => Auth::id()
        ]);
        return redirect()->route('admin.businesses.index')
            ->with('success', 'Business status changed to pending.');
    }

    /**
     * Remove the specified business from storage.
     */
    public function destroy(Business $business)
    {
        // Delete associated photos if they exist
        if ($business->foto && is_array($business->foto)) {
            foreach ($business->foto as $photo) {
                if (file_exists(public_path('storage/' . $photo))) {
                    unlink(public_path('storage/' . $photo));
                }
            }
        }
        
        $business->delete();

        return redirect()->route('admin.businesses.index')->with('success', 'Business deleted successfully.');
    }

    /**
     * Get pending businesses for notification popup.
     */
    public function getPendingBusinesses()
    {
        $pendingBusinesses = Business::where('status', 0)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get(['id', 'nama', 'email', 'foto', 'created_at']);
        
        return response()->json([
            'success' => true,
            'count' => Business::where('status', 0)->count(),
            'businesses' => $pendingBusinesses
        ]);
    }
}
