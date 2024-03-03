<?php

namespace App\Components;

class DataProcessor
{
    public function processData($settings, $records)
    {
        $limit = $settings['limit'] ?? 999;
        $page = $settings['page'] ?? 1;

        if (isset($settings['filters'])) {
            $filters = $this->changeFilters($settings['filters']);
            foreach ($filters as $filter) {
                if ($filter['operator'] === "like") {
                    $records->where($filter['field'], "like", "%" . $filter['value'] . "%");
                } elseif ($filter['operator'] === "equal") {
                    $records->where($filter['field'], $filter['value']);
                } elseif ($filter['operator'] === "increase") {
                    $records->where($filter['field'], ">", $filter['value']);
                } elseif ($filter['operator'] === "decrease") {
                    $records->where($filter['field'], "<", $filter['value']);
                }
            }
        }

        if(isset($settings['sort'])) {
            $sort = $settings['sort'];
            $records->orderBy($sort['field'], $sort['order']);
        }

        $records = $records->paginate($limit, ['*'], 'page', $page);

        return $records->items();
    }
    public function changeFilters($filters)
    {
        foreach ($filters as $key => $item) {
            if ($item['field'] == 'category.name') {
                $filters[$key]['field'] = 'category_id';
            }
            if ($item['field'] == 'sub_category.name') {
                $filters[$key]['field'] = 'sub_category_id';
            }
        }
        return $filters;
    }
}
