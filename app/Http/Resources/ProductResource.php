<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $this->getImage(),
            'categories' => CategoryResource::collection($this->categories)
        ];
    }

    // convert product image to a valid base64 format
    private function getImage(): string {
        return 'data:image;base64,'.base64_encode($this->image);
    }
}
