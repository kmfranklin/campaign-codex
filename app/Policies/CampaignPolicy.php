<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\User;

class CampaignPolicy
{
    /**
     * Determine whether the user can view any campaigns.
     * For now, allow all authenticated users to see the index.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the campaign.
     * For now, allow all authenticated users to view.
     */
    public function view(User $user, Campaign $campaign): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create campaigns.
     * Allow any authenticated user to create.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the campaign.
     * Only the DM/owner can update.
     */
    public function update(User $user, Campaign $campaign): bool
    {
        return $campaign->dm_id === $user->id;
    }

    /**
     * Determine whether the user can delete the campaign.
     * Only the DM/owner can delete.
     */
    public function delete(User $user, Campaign $campaign): bool
    {
        return $campaign->dm_id === $user->id;
    }

    /**
     * Determine whether the user can restore the campaign.
     * Only the DM/owner can restore.
     */
    public function restore(User $user, Campaign $campaign): bool
    {
        return $campaign->dm_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the campaign.
     * Only the DM/owner can force delete.
     */
    public function forceDelete(User $user, Campaign $campaign): bool
    {
        return $campaign->dm_id === $user->id;
    }

    /**
     * Custom: Determine whether the user can add members.
     */
    public function addMember(User $user, Campaign $campaign): bool
    {
        return $campaign->dm_id === $user->id;
    }

    /**
     * Custom: Determine whether the user can remove members.
     */
    public function removeMember(User $user, Campaign $campaign): bool
    {
        return $campaign->dm_id === $user->id;
    }
}
