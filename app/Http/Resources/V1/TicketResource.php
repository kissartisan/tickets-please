<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
//    public static $wrap = 'ticket';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'type' => 'ticket',
            'id' => (string) $this->id,
            'attributes' => [
                'title' => $this->title,
                'description' => $this->when($request->routeIs('tickets.show'), $this->description),
                'status' => $this->status,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => [
                'author' => [
                    'data' => [
                        'type' => 'user',
                        'id' => (string) $this->user_id,
                    ],
                    'links' => [
                        'self' => 'todo', //route('api.v1.users.show', ['user' => $this->user_id]),
                    ],
                ],
            ],
            'includes' => [
                new UserResource($this->user),
            ],
            'links' => [
                'self' => route('tickets.show', ['ticket' => $this->id]),
            ],
        ];
    }
}
