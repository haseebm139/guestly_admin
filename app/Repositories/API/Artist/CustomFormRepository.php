<?php

namespace App\Repositories\API\Artist;

use App\Models\CustomForm;
use Illuminate\Support\Facades\DB;

class CustomFormRepository implements CustomFormRepositoryInterface
{
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $form = CustomForm::create([
                'artist_id' => $data['artist_id'],
                'title' => $data['title']
            ]);

            foreach ($data['fields'] as $field) {
                $form->fields()->create($field);
            }

            return $form->load('fields');
        });
    }

    public function getByArtist($artistId)
    {
        return CustomForm::with('fields')->where('artist_id', $artistId)->get();
    }

    public function getById($id)
    {
        return CustomForm::with('fields')->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $form = CustomForm::findOrFail($id);
        $form->update([
            'title' => $data['title'] ?? $form->title,
        ]);

        // Delete existing fields and re-create (or you can update smartly if needed)
        $form->fields()->delete();

        foreach ($data['fields'] as $field) {
            $form->fields()->create([
                'label' => $field['label'],
                'type' => $field['type'],
                'options' => isset($field['options']) ? json_encode($field['options']) : null,
                'is_required' => $field['is_required'] ?? 1,
                'order' => $field['order'] ?? 0,
            ]);
        }

        return $form->load('fields');
    }

    public function delete($id)
    {
        $form = CustomForm::findOrFail($id);
        return $form->delete();
    }
}
