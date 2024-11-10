<?php

namespace App\Observers;

use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class SectionObserver
{
    /**
     * Handle the Section "created" event.
     *
     * @return void
     */
    public function created(Section $section)
    {
        $this->updateUserSectionId($section);
    }

    /**
     * Handle the Section "updated" event.
     *
     * @return void
     */
    public function updated(Section $section)
    {
        $this->updateUserSectionId($section);
    }

    /**
     * Update the section_id for the assigned user.
     *
     * @return void
     */
    protected function updateUserSectionId(Section $section)
    {
        if ($section->user_id) {
            $updated = User::where('id', $section->user_id)->update(['section_id' => $section->id]);

            if ($updated) {
                Log::info('Section ID updated for user', ['user_id' => $section->user_id, 'section_id' => $section->id]);
            } else {
                Log::warning('Failed to update section_id for user', ['user_id' => $section->user_id]);
            }
        }
    }
}
