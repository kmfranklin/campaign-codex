<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * Display a listing of the campaigns the user can see.
     * - Later: paginate, filter, and scope by membership/visibility.
     */
    public function index()
    {
        // TODO: Fetch campaigns visible to the current user (e.g., member or public).
        // TODO: Return a Blade view with a paginated list.
    }

    /**
     * Show the form for creating a new campaign.
     * - DM-only: enforce via CampaignPolicy or gate in controller temporarily.
     */
    public function create()
    {
        // TODO: Authorize DM-only creation.
        // TODO: Return a Blade view with a create form.
    }

    /**
     * Store a newly created campaign in storage.
     * - Validate via FormRequest later.
     * - Set current user as DM/owner in pivot/user role.
     */
    public function store(Request $request)
    {
        // TODO: Validate input (use a FormRequest in a later step).
        // TODO: Create campaign and attach current user as DM/owner.
        // TODO: Redirect to show with success message.
    }

    /**
     * Display the specified campaign.
     * - Show core campaign data and membership status.
     */
    public function show(Campaign $campaign)
    {
        // TODO: Authorize view based on membership/visibility.
        // TODO: Return a Blade view showing campaign details.
    }

    /**
     * Show the form for editing the specified campaign.
     * - DM-only: enforce via CampaignPolicy.
     */
    public function edit(Campaign $campaign)
    {
        // TODO: Authorize DM-only edit.
        // TODO: Return a Blade view with an edit form.
    }

    /**
     * Update the specified campaign in storage.
     * - Validate via FormRequest; authorize via policy.
     */
    public function update(Request $request, Campaign $campaign)
    {
        // TODO: Authorize DM-only update.
        // TODO: Validate input (use a FormRequest in a later step).
        // TODO: Update campaign and redirect with success message.
    }

    /**
     * Remove the specified campaign from storage.
     * - DM-only: soft-delete or hard-delete per product choice (decide later).
     */
    public function destroy(Campaign $campaign)
    {
        // TODO: Authorize DM-only delete.
        // TODO: Delete campaign and redirect with success message.
    }

    /**
     * Add a member to the campaign.
     * - DM-only; will later use a dedicated route and FormRequest.
     */
    public function addMember(Request $request, Campaign $campaign)
    {
        // TODO: Authorize DM-only member management.
        // TODO: Validate target user and desired role (e.g., player).
        // TODO: Attach user to campaign with role on pivot.
    }

    /**
     * Remove a member from the campaign.
     * - DM-only; careful with self-removal/transfer of ownership.
     */
    public function removeMember(Request $request, Campaign $campaign)
    {
        // TODO: Authorize DM-only member management.
        // TODO: Validate target user.
        // TODO: Detach user from campaign.
    }
}
