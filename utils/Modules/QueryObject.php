<?php

namespace Utils\Modules;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;

class QueryObject implements Arrayable
{
    public Expression $query;
    public array $bindings;

    public function __construct(string $query, array $bindings = [])
    {
        $this->bindings = $bindings;
        $this->query = DB::raw($query);
    }

    #[ArrayShape(['query' => "\Illuminate\Database\Query\Expression", 'bindings' => "array"])]
    public function toArray(): array
    {
        return ['query' => $this->query, 'bindings' => $this->bindings];
    }

    public function getValues(): array
    {
        return array_values($this->toArray());
    }
}
