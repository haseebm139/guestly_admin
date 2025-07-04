<?php
namespace App\Interfaces;

use Illuminate\Http\Request;

interface PlanRepositoryInterface
{
    public function allPlans();
    public function allFeatures();
    public function createPlan(array $data);
    public function findPlan($id);
    public function updatePlan($id, array $data);
    public function deletePlan($id);
    public function changeStatus($id, $status);
}
