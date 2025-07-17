<?php

namespace App\Http\Controllers\Api\V1\Artist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\API\Artist\CustomFormRepositoryInterface;
use App\Http\Requests\API\Artist\StoreCustomFormRequest;
use App\Http\Requests\API\Artist\UpdateCustomFormRequest;

use App\Http\Controllers\Api\BaseController as BaseController;
class CustomFormController extends BaseController
{
    protected $formRepo;
    public function __construct(CustomFormRepositoryInterface $formRepo)
    {
        $this->formRepo = $formRepo;
    }

    public function store(StoreCustomFormRequest $request)
    {
        $validated = $request->validated();
        $validated['artist_id'] = auth()->id();

        try {
            $form = $this->formRepo->create($validated);
            return $this->sendResponse($form, 'Form created successfully.', 201);
        } catch (\Throwable $e) {
            return $this->sendError('Something went wrong.', 500);
        }
    }


    public function index()
    {
        $artistId = auth()->id();
        $forms = $this->formRepo->getByArtist($artistId);
        return $this->sendResponse($forms, 'Forms fetched successfully.');
    }

    public function show($id)
    {
        try {
            $form = $this->formRepo->getById($id);
            return $this->sendResponse($form, 'Form fetched successfully.');
        } catch (\Throwable $e) {
            return $this->sendError('Form not found.', 404);
        }
    }

    public function update(UpdateCustomFormRequest $request, $id)
    {

        if (is_null($id)) {
            return $this->sendError('Form ID is required.', 400);
        }

        try {
            $form = $this->formRepo->update($id, $request->validated());

            if (!$form) {
                return $this->sendError('Form not found.', 404);
            }

            return $this->sendResponse($form, 'Form updated successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong.', 500);
        }
    }

    public function destroy($id)
    {

        try {

            $form = $this->formRepo->getById($id);


            $this->formRepo->delete($id);
            return $this->sendResponse([], 'Form deleted successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong.', 500);
        }
    }




}
