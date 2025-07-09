<?php
namespace App\Repositories\API;
use App\Models\Card;

class CardRepository implements CardRepositoryInterface
{
    public function all($userId)
    {
        return Card::where('user_id', $userId)->get();
    }

    public function find($id, $userId)
    {
        return Card::where('id', $id)->where('user_id', $userId)->first();
    }

    public function store(array $data)
    {

        return Card::create($data);
    }

    public function update($id, array $data, $userId)
    {
        $card = $this->find($id, $userId);
        if ($card) {
            $card->update($data);
        }
        return $card;
    }

    public function delete($id, $userId)
    {
        $card = $this->find($id, $userId);
        if ($card) {
            $card->delete();
        }
        return $card;
    }
}
