<div class="row" id="rowModsServers">
    <div class="col-md-12">
        <div class="mods__wrapper mods__row-5 mods__centered mods-ready">
            @foreach($modes as $mode)
                <article class="mods__card" data-mod="{{ $mode['name'] }}">
                    <div class="mods__art"></div>
                    <div class="mods__servers-counter">@svg('server')<span class="mods__servers-count">{{ $mode['servers'] }}</span></div>
                    <div class="mods__info"><div class="mods__title">{{ $mode['name'] }}</div><div class="mods__online"><span class="ring-online"></span><span>{{ $mode['players'] }}</span> в игра</div></div>
                    <div class="mods__shadow"></div>
                    <div class="mod__bottom-info"><div class="mod__desc-text">{{ $mode['desc'] }}</div><button class="mods__button-search active filter" type="button">@svg('play') Бърза игра</button></div>
                </article>
            @endforeach
            <div class="mods__card servers__card-block-empty"></div>
        </div>
    </div>
</div>
