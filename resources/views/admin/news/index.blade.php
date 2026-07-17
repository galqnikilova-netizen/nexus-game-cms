<x-layouts.admin title="Новини · NEXUS" heading="Новини и публикации">
    <section class="admin-panel">
        <div class="panel-head"><div><small>CONTENT MANAGER</small><h2>Всички новини</h2></div><a class="btn btn-primary" href="{{ route('admin.news.create') }}">+ Нова новина</a></div>
        <div class="news-admin-list">
            @forelse($posts as $post)
                <article>
                    @if($post->imageUrl())<img src="{{ $post->imageUrl() }}" alt="">@else<span>NEWS</span>@endif
                    <div><small>{{ strtoupper($post->category) }} · {{ $post->is_published ? 'PUBLISHED' : 'DRAFT' }}</small><b>{{ $post->title }}</b><p>{{ $post->excerpt }}</p></div>
                    <time>{{ ($post->published_at ?? $post->created_at)->format('d.m.Y H:i') }}</time>
                    <div class="news-admin-actions"><a href="{{ route('admin.news.edit',$post) }}">Редакция</a><form method="POST" action="{{ route('admin.news.destroy',$post) }}" onsubmit="return confirm('Да изтрия ли новината?')">@csrf @method('DELETE')<button>Изтрий</button></form></div>
                </article>
            @empty
                <div class="empty-state"><h3>Все още няма новини</h3><p>Създай първата публикация.</p></div>
            @endforelse
        </div>
        {{ $posts->links() }}
    </section>
</x-layouts.admin>
