<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/** @mixin User */
class UserResource extends JsonResource
{
    private const USER_RESOURCE_SHAPE = [
        'id' => "int",
        'name' => "string",
        'email' => "string",
        'role' => "string",
        'created_at' => "\Illuminate\Support\Carbon|null",
        'updated_at' => "\Illuminate\Support\Carbon|null"
    ];

    public $additional = ['success' => true];

    /**
     * @param Request $request
     * @return array
     */
    #[ArrayShape(self::USER_RESOURCE_SHAPE)]
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            # 'email_verified_at' => $this->email_verified_at,
            # 'password' => $this->password,
            'role' => $this->role,
            # 'remember_token' => $this->remember_token,
            # 'current_team_id' => $this->current_team_id,
            # 'profile_photo_path' => $this->profile_photo_path,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            # 'two_factor_secret' => $this->two_factor_secret,
            # 'two_factor_recovery_codes' => $this->two_factor_recovery_codes,
            # 'two_factor_confirmed_at' => $this->two_factor_confirmed_at,
            # 'profile_photo_url' => $this->profile_photo_url,
            # 'notifications_count' => $this->notifications_count,
        ];
    }
}
