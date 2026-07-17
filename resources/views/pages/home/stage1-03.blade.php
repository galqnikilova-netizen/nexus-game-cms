<div class="row" id="rowModFilter">
    <div class="col-md-12">
        <div class="servers_filter">
            <div class="filter_chips"><button class="filter active mode" type="button">Всички</button>@foreach($modes as $mode)<button class="filter mode" type="button">{{ $mode['name'] }}</button>@endforeach</div>
            <div class="servers_filter-data"><span class="servers_filter-update-button">@svg('settings') Обновено преди секунди</span></div>
        </div>
        <div class="modFilter__filter-wrapper">
            <div class="adaptive-select-wrapper"><div class="adaptive-select"><span>Изглед: Карти</span>@svg('chevron')</div></div>
            <div class="adaptive-select-wrapper"><div class="adaptive-select"><span>Категория: Всички</span>@svg('chevron')</div></div>
            <div class="adaptive-select-wrapper"><div class="adaptive-select"><span>Карта: Всички</span>@svg('chevron')</div></div>
            <div class="adaptive-select-wrapper"><div class="adaptive-select"><span>Локация: Европа</span>@svg('chevron')</div></div>
            <div class="inputs-inline modFilter__unset"><input id="filterHideEmptys" class="switch" type="checkbox"><label for="filterHideEmptys">Скрий празните</label></div>
        </div>
    </div>
</div>
