<x-layouts.admin title="Dashboard · NEXUS" heading="Dashboard">
@php($health=$stats['servers']?round(($stats['online']/$stats['servers'])*100):0)
<section class="n3-metric-grid">
    @foreach([
        ['USERS',$stats['users'],'Registered community profiles','users'],
        ['SERVERS',$stats['servers'],$stats['online'].' currently online','servers'],
        ['PLAYERS',$stats['players'],'Players across the network','community'],
        ['NETWORK HEALTH',$health.'%','Successful server responses','dashboard']
    ] as $metric)
        <article class="n3-panel n3-metric"><div class="n3-metric-head"><span>{{ $metric[0] }}</span><i class="n3-metric-icon not-italic"><x-nx-icon :name="$metric[3]"/></i></div><strong>{{ $metric[1] }}</strong><p>{{ $metric[2] }}</p></article>
    @endforeach
</section>
<section class="n3-admin-grid">
    <div class="n3-panel overflow-hidden">
        <header class="n3-heading mb-0 px-5 py-4"><div><span class="n3-eyebrow">Live infrastructure</span><h2>Server network</h2></div><a class="n3-button min-h-9" href="{{ route('admin.servers.create') }}">+ Add server</a></header>
        <div class="n3-admin-table-head"><span>Server</span><span>Map</span><span>Players</span><span>Status</span></div>
        @forelse($servers as $server)
            <div class="n3-admin-row"><div class="min-w-0"><strong class="block truncate text-[11px]">{{ $server->name }}</strong><small class="mt-1 block text-[8px] text-slate-600">{{ $server->host }}:{{ $server->port }} · {{ strtoupper($server->game) }}</small></div><span>{{ $server->current_map ?: '—' }}</span><strong>{{ $server->players_online }}/{{ $server->players_max }}</strong><span class="n3-state {{ $server->status==='online'?'online':'offline' }}">{{ $server->status }}</span></div>
        @empty<div class="p-14 text-center text-xs text-slate-500">Add your first server to begin monitoring.</div>@endforelse
    </div>
    <aside class="grid content-start gap-[10px]">
        <section class="n3-panel overflow-hidden"><header class="px-4 py-4"><span class="n3-eyebrow">Shortcuts</span><h3 class="mt-2 text-sm font-extrabold">Quick actions</h3></header><a class="n3-quick-link" href="{{ route('admin.news.create') }}"><x-nx-icon name="news"/>Publish news<span>→</span></a><a class="n3-quick-link" href="{{ route('admin.servers.create') }}"><x-nx-icon name="servers"/>Add server<span>→</span></a><a class="n3-quick-link" href="{{ route('admin.users.index') }}"><x-nx-icon name="users"/>Manage users<span>→</span></a><a class="n3-quick-link" href="{{ route('admin.settings.edit') }}"><x-nx-icon name="settings"/>Appearance<span>→</span></a></section>
        <section class="n3-panel n3-stat"><h3>System snapshot</h3><div class="n3-stat-row"><span>Laravel</span><strong>{{ app()->version() }}</strong></div><div class="n3-stat-row"><span>Environment</span><strong>{{ strtoupper(app()->environment()) }}</strong></div><div class="n3-stat-row"><span>Last refresh</span><strong>{{ now()->format('H:i') }}</strong></div></section>
    </aside>
</section>
</x-layouts.admin>
