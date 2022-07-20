<?php

namespace App\Actions\Validators;

use App\Rules\MaxLength;
use App\Rules\MaxSize;
use App\Rules\MinLength;
use App\Rules\MinSize;
use App\Rules\ValidGameName;
use App\Rules\ValidGameRegion;
use App\Rules\ValidGameType;
use JetBrains\PhpStorm\Pure;

trait GameValidationRulesTrait
{
    protected function gameNameRules(array $rules = ['required']): array
    {
        return [...$rules, 'string', new MinLength(MIN_GAME_NAME_LENGTH), new MaxLength(MAX_GAME_NAME_LENGTH), new ValidGameName];
    }

    protected function dateReleasedRules(array $rules = ['required']): array
    {
        return [...$rules, 'date'];
    }

    protected function gameTypeRules(array $rules = ['required']): array
    {
        return [...$rules, 'string', new MinLength(MIN_GAME_TYPE_LENGTH), new MaxLength(MAX_GAME_TYPE_LENGTH), new ValidGameType];
    }

    protected function gameRegionRules(array $rules = ['required']): array
    {
        return [...$rules, 'string', new MinLength(MIN_GAME_REGION_LENGTH), new MaxLength(MAX_GAME_REGION_LENGTH), new ValidGameRegion];
    }

    #[Pure]
    protected function gameGenerationRules(array $rules = ['required']): array
    {
        return [...$rules, 'integer', new MinSize(MIN_GAME_GENERATION_VALUE), new MaxSize(MAX_GAME_GENERATION_VALUE)];
    }
}
