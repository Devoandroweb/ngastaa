<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // dd($this->user->name);
        return [
            'user' => $this->user->name,
            'foto' => $this->user->foto(),
            'target' => optional($this->target)->name,
            'action' => badgeApproval($this->action),
            // 'action' => $this->action,
            'tanggal' => date('d-m-Y  H:i', strtotime($this->created_at))
        ];
    }
}
