<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\User;
use App\Models\Role;

class CampaignPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Campaign $campaign): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function manage(User $user, Campaign $campaign): bool
    {
        return $campaign->members()
            ->wherePivotIn('role_id', [Role::DM, Role::CO_DM])
            ->where('user_id', $user->id)
            ->exists();
    }

    // Update uses manage()
    public function update(User $user, Campaign $campaign): bool
    {
        return $this->manage($user, $campaign);
    }

    // Delete = DM only
    public function delete(User $user, Campaign $campaign): bool
    {
        return $campaign->members()
            ->wherePivot('role_id', Role::DM)
            ->where('user_id', $user->id)
            ->exists();
    }

    public function restore(User $user, Campaign $campaign): bool
    {
        return $this->delete($user, $campaign);
    }

    public function forceDelete(User $user, Campaign $campaign): bool
    {
        return $this->delete($user, $campaign);
    }

    // Membership management = DM or Co‑DM
    public function addMember(User $user, Campaign $campaign): bool
    {
        return $this->manage($user, $campaign);
    }

    public function removeMember(User $user, Campaign $campaign): bool
    {
        return $this->manage($user, $campaign);
    }
}
