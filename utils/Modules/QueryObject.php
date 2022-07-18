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

    /**
     * Call {@see QueryObject::getValues getValues} accessor method on invocation
     *
     * @return array
     */
    public function __invoke(): array
    {
        return $this->getValues();
    }

    /**
     * Converts to associative array
     *
     * @return array
     */
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
