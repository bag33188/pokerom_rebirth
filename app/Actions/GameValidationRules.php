<?php

namespace App\Actions;

use App\Rules\MaxLength;
use App\Rules\MaxSize;
use App\Rules\MinLength;
use App\Rules\MinSize;
use App\Rules\ValidGameName;
use App\Rules\ValidGameRegion;
use App\Rules\ValidGameType;

trait GameValidationRules
{
    protected function gameNameRules(array $rules = ['required']): array
    {
        return [...$rules, 'string', new MinLength(MIN_GAME_NAME), new MaxLength(MAX_GAME_NAME), new ValidGameName];
    }

    protected function dateReleasedRules(array $rules = ['required']): array
    {
        return [...$rules, 'date'];
    }

    protected function gameTypeRules(array $rules = ['required']): array
    {
        return [...$rules, 'string', new MinLength(MIN_GAME_TYPE), new MaxLength(MAX_GAME_TYPE), new ValidGameType];
    }

    protected function gameRegionRules(array $rules = ['required']): array
    {
        return [...$rules, 'string', new MinLength(MIN_GAME_REGION), new MaxLength(MAX_GAME_REGION), new ValidGameRegion];
    }

    protected function gameGenerationRules(array $rules = ['required']): array
    {
        return [...$rules, 'integer', new MinSize(MIN_GAME_GENERATION), new MaxSize(MAX_GAME_GENERATION)];
    }
}
