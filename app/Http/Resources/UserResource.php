<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $user = $this?->loadMissing('roles.permissions');
        $permissions = [];
        $roles = [];

        if($user) {
          foreach($user->roles as $role) {
            $roles[] = [
              'id' => $role->id,
              'title' => $role->title,
            ];

            foreach($role->permissions as $singlePermission) {
              $permissions[] = $singlePermission->title;
            }
          }
        }

        return [
          'id' => $this->id,
          'name' => $this->name,
          'email' => $this->email,
          // 'status' => $this->status ? 'Active' : 'Inactive',
          'created_at' => $this->created_at,
          'roles' => $roles,
          'permissions' => collect($permissions)->unique()->map(function($permission) {
            return [
              $permission => true
            ];
          })->collapse()->toArray()
        ];
    }
}
