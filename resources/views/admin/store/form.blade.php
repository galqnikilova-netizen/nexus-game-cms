<x-layouts.admin title="{{ $product->exists?'Edit product':'New product' }} · NEXUS" heading="{{ $product->exists?'Edit Product':'New Product' }}">
<form class="n3-panel overflow-hidden" method="POST" action="{{ $product->exists?route('admin.products.update',$product):route('admin.products.store') }}">@csrf @if($product->exists)@method('PUT')@endif
<header class="border-b border-white/[.06] p-5"><span class="n3-eyebrow">Store catalog</span><h2 class="mt-2 text-lg font-extrabold">Product information</h2></header>
<div class="grid gap-5 p-5 md:grid-cols-2">
    <label class="text-[10px] text-slate-400">Name<input class="n3-input mt-2" name="name" value="{{ old('name',$product->name) }}" required></label>
    <label class="text-[10px] text-slate-400">Slug<input class="n3-input mt-2" name="slug" value="{{ old('slug',$product->slug) }}" placeholder="auto-generated"></label>
    <label class="text-[10px] text-slate-400">Category<input class="n3-input mt-2" name="category" value="{{ old('category',$product->category?:'vip') }}" required></label>
    <label class="text-[10px] text-slate-400">Server<select class="n3-input mt-2" name="game_server_id"><option value="">Global</option>@foreach($servers as $server)<option value="{{ $server->id }}" @selected(old('game_server_id',$product->game_server_id)==$server->id)>{{ $server->name }}</option>@endforeach</select></label>
    <label class="text-[10px] text-slate-400">Price EUR<input class="n3-input mt-2" type="number" min="0" step="0.01" name="price" value="{{ old('price',$product->price?:0) }}" required></label>
    <label class="text-[10px] text-slate-400">Duration days<input class="n3-input mt-2" type="number" min="1" name="duration_days" value="{{ old('duration_days',$product->duration_days) }}"></label>
    <label class="text-[10px] text-slate-400">Accent<input class="n3-input mt-2 h-11" type="color" name="accent" value="{{ old('accent',$product->accent?:'#7c86ff') }}" required></label>
    <label class="text-[10px] text-slate-400">Sort order<input class="n3-input mt-2" type="number" min="0" name="sort_order" value="{{ old('sort_order',$product->sort_order?:0) }}" required></label>
    <label class="text-[10px] text-slate-400 md:col-span-2">Description<textarea class="n3-input mt-2 min-h-24" name="description">{{ old('description',$product->description) }}</textarea></label>
    <label class="text-[10px] text-slate-400 md:col-span-2">Features — one per line<textarea class="n3-input mt-2 min-h-32" name="features_text">{{ old('features_text',implode("\n",$product->features??[])) }}</textarea></label>
    <label class="flex items-center gap-3 text-[10px]"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured',$product->is_featured))> Featured product</label>
    <label class="flex items-center gap-3 text-[10px]"><input type="checkbox" name="is_active" value="1" @checked(old('is_active',$product->exists?$product->is_active:true))> Active</label>
</div>
<footer class="flex justify-end gap-2 border-t border-white/[.06] p-5"><a class="n3-button ghost" href="{{ route('admin.products.index') }}">Cancel</a><button class="n3-button">Save product</button></footer>
</form>
@if($product->exists)<form method="POST" action="{{ route('admin.products.destroy',$product) }}" class="mt-3 text-right">@csrf @method('DELETE')<button class="text-[9px] font-bold text-rose-400" onclick="return confirm('Delete or archive this product?')">DELETE / ARCHIVE PRODUCT</button></form>@endif
</x-layouts.admin>
