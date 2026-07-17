<x-layouts.admin title="{{ $post->exists ? 'Редакция' : 'Нова новина' }} · NEXUS" heading="{{ $post->exists ? 'Редакция на новина' : 'Създаване на новина' }}">
    <form class="admin-form news-editor" method="POST" enctype="multipart/form-data" action="{{ $post->exists ? route('admin.news.update',$post) : route('admin.news.store') }}">
        @csrf @if($post->exists)@method('PUT')@endif
        <div class="form-section">
            <div><small>CONTENT EDITOR</small><h2>Публикация</h2><p>Добави заглавие, кратък текст, пълно съдържание и cover изображение.</p>@if($post->imageUrl())<img class="news-current-image" src="{{ $post->imageUrl() }}" alt="">@endif</div>
            <div class="form-grid">
                <label class="wide">Заглавие<input name="title" value="{{ old('title',$post->title) }}" maxlength="180" required></label>
                <label>Категория<input name="category" value="{{ old('category',$post->category ?: 'Community') }}" maxlength="80" required></label>
                <label>Основно изображение<input type="file" name="image" accept="image/jpeg,image/png,image/webp"></label>
                <label class="wide">Кратко описание<textarea name="excerpt" rows="4" maxlength="500" required>{{ old('excerpt',$post->excerpt) }}</textarea><small>Показва се в картите и началната страница.</small></label>
                <label class="wide">Пълно описание<textarea name="content" rows="18" maxlength="50000" required>{{ old('content',$post->content) }}</textarea><small>Поддържа обикновен текст и нови редове.</small></label>
                <label class="toggle"><input type="checkbox" name="is_published" value="1" @checked(old('is_published',$post->is_published))><span>Публикувана</span></label>
                <label class="toggle"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured',$post->is_featured))><span>Водеща новина</span></label>
            </div>
        </div>
        @if($errors->any())<div class="editor-errors">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
        <div class="form-actions"><a class="btn btn-quiet" href="{{ route('admin.news.index') }}">Отказ</a><button class="btn btn-primary">{{ $post->exists ? 'Запази промените' : 'Създай новината' }}</button></div>
    </form>
</x-layouts.admin>
