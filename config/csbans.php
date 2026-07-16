<?php return ['enabled'=>(bool)env('CSBANS_ENABLED',false),'connection'=>'csbans','prefix'=>env('CSBANS_TABLE_PREFIX','amx'),'cache_seconds'=>(int)env('CSBANS_CACHE_SECONDS',60)];
