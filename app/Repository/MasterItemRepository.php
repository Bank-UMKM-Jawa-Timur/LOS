<?php

namespace App\Repository;
use App\Models\ItemModel;
use App\Models\JawabanModel;
use App\Models\JawabanTextModel;

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

    public function getWithJawaban($pengajuan_id, $without_id=[]) {
        $items = ItemModel::with([
                            'childs' => function($query) use ($pengajuan_id) {
                                $query->with([
                                    'option' => function($query) use ($pengajuan_id) {
                                        // $query->with('jawaban')->where('jawaban.id_pengajuan', $pengajuan_id);
                                    },
                                    'childs' => function($query) use ($pengajuan_id) {
                                        $query->with([
                                            'option' => function($query) use ($pengajuan_id) {
                                                // $query->with('jawaban')->where('jawaban.id_pengajuan', $pengajuan_id);
                                            },
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

        foreach ($items as $key => $value) {
            if ($value->childs) {
                // Lev 2
                if ($value->opsi_jawaban != "kosong") {
                    foreach ($value->childs as $c) {
                        if ($c->option) {
                            foreach ($c->option as $opt) {
                                $jawaban = JawabanModel::where('id_pengajuan', $pengajuan_id)
                                                    ->where('id_jawaban', $opt->id)
                                                    ->first();
                                $opt->jawaban = $jawaban;
                            }
                        }

                        if ($c->opsi_jawaban != "kosong") {
                            $jawaban = JawabanTextModel::where('id_pengajuan', $pengajuan_id)
                                                        ->where('id_jawaban', $c->id)
                                                        ->first();
                            $c->jawaban = $jawaban;
                        }

                        if ($c->childs) {
                            // Lev 3
                            foreach ($c->childs as $c2) {
                                if ($c2->opsi_jawaban != "kosong") {
                                    $jawaban = JawabanTextModel::where('id_pengajuan', $pengajuan_id)
                                                                ->where('id_jawaban', $c2->id)
                                                                ->first();
                                    $c2->jawaban = $jawaban;
                                }
                                if ($c2->option) {
                                    foreach ($c2->option as $opt2) {
                                        $jawaban = JawabanModel::where('id_pengajuan', $pengajuan_id)
                                                            ->where('id_jawaban', $opt2->id)
                                                            ->first();
                                        $opt2->jawaban = $jawaban;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $items;
    }
}
