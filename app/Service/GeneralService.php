<?php

namespace App\Service;


use App\Models\PostEvent\PostEvent;
use Illuminate\Database\Eloquent\Model;

class GeneralService
{
   public function addAmount(int $post_id, float $amount = 1000):?Model
   {
      return PostEvent::create(['post_id'=>$post_id,'amount'=>$amount]);
   }
}
