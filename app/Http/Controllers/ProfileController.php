<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $activities = $this->getActivity($user);
        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => $activities
        ]);
    }

    /**
     * @param User $user
     * @return Collection
     */
    protected function getActivity(User $user): Collection
    {
        return $user->activity()->latest()->with('subject')->take(50)->get()->groupBy(function ($activity) {
            return $activity->created_at->format('Y-m-d');
        });
    }
}
