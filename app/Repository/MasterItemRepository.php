<?php

namespace App\Repository;
use App\Models\ItemModel;

class MasterItemRepository
{
    public function get($without_id=[]) {
        $item = ItemModel::with([
                            'childs' => function($query) {
                                $query->with([
                                    'option',
                                    'childs' => function($query) {
                                        $query->with([
                                            'option',
                                            'childs' => function($query) {
                                                $query->where('level', 4)
                                                ->where('is_hide', 0)
                                                ->orderBy('sequence');
                                            }
                                        ])
                                        ->where('level', 3)
                                        ->where('is_hide', 0)
                                        ->orderBy('sequence');
                                    }
                                ])
                                    ->where('level', 2)
                                    ->where('is_hide', 0)
                                    ->orderBy('sequence');
                            }
                        ])
                        ->where('level', 1)
                        ->whereNotIn('id', $without_id)
                        ->where('is_hide', 0)
                        ->orderBy('sequence')
                        ->get();

        return $item;
    }
}