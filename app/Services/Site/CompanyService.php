<?php
namespace App\Services\Site;

use App\Models\Company;
use Illuminate\Support\Carbon;

class CompanyService
{

    public function get(): array
    {
        // Основной запрос с фильтрацией
        $query = Company::active();

        if (request()->get('way') && request()->get('way') !== '') {
            $query->where('way', request()->get('way'));
        }

        if(request()->get('city')) {
            $query->where('city', request()->get('city'));
        }

        if(request()->get('query')) {
            $query->where('title', 'LIKE', '%'.request()->get('query').'%');
        }

        // Общее количество записей (без пагинации)
        $total = (clone $query)->count();

        // Применяем пагинацию
        $resources = $query
            ->offset(request()->get('page') * 6)
            ->limit(6)
            ->get();

        return [
            'items' => $resources,
            'total' => $total,
        ];
    }
}
