<?php

namespace App\Traits;

trait Searchable
{
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    protected function applySearch($query, array $columns): mixed
    {
        return $query->when($this->search, function ($q) use ($columns) {
            $q->where(function ($sub) use ($columns) {
                foreach ($columns as $i => $column) {
                    $method = $i === 0 ? 'where' : 'orWhere';
                    // Support dot-notation untuk relasi: 'level.name'
                    if (str_contains($column, '.')) {
                        [$relation, $field] = explode('.', $column, 2);
                        $sub->orWhereHas($relation, fn($r) => $r->where($field, 'like', "%{$this->search}%"));
                    } else {
                        $sub->$method($column, 'like', "%{$this->search}%");
                    }
                }
            });
        });
    }
}
