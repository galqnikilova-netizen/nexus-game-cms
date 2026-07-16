<?php
namespace App\Services; use App\Models\ActivityLog; use Illuminate\Database\Eloquent\Model;
class ActivityLogger { public function record(string $event,?Model $subject=null,array $properties=[]):void { ActivityLog::create(['user_id'=>auth()->id(),'event'=>$event,'subject_type'=>$subject?->getMorphClass(),'subject_id'=>$subject?->getKey(),'properties'=>$properties,'ip_address'=>request()->ip(),'user_agent'=>mb_substr((string)request()->userAgent(),0,500)]); } }
