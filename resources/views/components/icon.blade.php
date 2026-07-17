@php($name = $name ?? 'circle')
<svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
@switch($name)
@case('home')<path d="M3 11.5 12 4l9 7.5v8a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1z"/>@break
@case('trophy')<path d="M8 4h8v3c0 4-1.5 6-4 7-2.5-1-4-3-4-7zM8 6H4v2c0 2 1.5 3 4 3m8-5h4v2c0 2-1.5 3-4 3M12 14v4m-4 2h8"/>@break
@case('gavel')<path d="m14 5 5 5m-8-2 5 5M6 18l7-7m-9 9h9"/>@break
@case('search')<circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>@break
@case('store')<path d="M4 10v10h16V10M3 4h18l-2 6H5zM9 20v-6h6v6"/>@break
@case('sparkles')<path d="m12 3 1.3 3.7L17 8l-3.7 1.3L12 13l-1.3-3.7L7 8l3.7-1.3zM5 15l.8 2.2L8 18l-2.2.8L5 21l-.8-2.2L2 18l2.2-.8zM19 14l.8 2.2L22 17l-2.2.8L19 20l-.8-2.2L16 17l2.2-.8z"/>@break
@case('ticket')<path d="M3 7h18v4a2 2 0 0 0 0 4v4H3v-4a2 2 0 0 0 0-4z"/><path d="M13 7v12"/>@break
@case('book')<path d="M4 5a3 3 0 0 1 3-2h5v17H7a3 3 0 0 0-3 2zM20 5a3 3 0 0 0-3-2h-5v17h5a3 3 0 0 1 3 2z"/>@break
@case('help')<circle cx="12" cy="12" r="9"/><path d="M9.7 9a2.4 2.4 0 1 1 3.8 2c-1.2.8-1.5 1.4-1.5 2.5M12 17h.01"/>@break
@case('users')<path d="M16 20v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 10a4 4 0 1 0 0-8m13 18v-2a4 4 0 0 0-3-3.87m-2-11.9a4 4 0 0 1 0 7.75"/>@break
@case('server')<rect x="3" y="4" width="18" height="6" rx="2"/><rect x="3" y="14" width="18" height="6" rx="2"/><path d="M7 7h.01M7 17h.01"/>@break
@case('shield')<path d="M12 3 20 6v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"/><path d="m9 12 2 2 4-4"/>@break
@case('clock')<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>@break
@case('copy')<rect x="8" y="8" width="11" height="11" rx="2"/><path d="M16 8V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h3"/>@break
@case('play')<path d="m8 5 11 7-11 7z"/>@break
@case('arrow')<path d="M5 12h14m-6-6 6 6-6 6"/>@break
@case('filter')<path d="M4 6h16M7 12h10M10 18h4"/>@break
@case('bell')<path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/>@break
@case('chevron')<path d="m9 10 3 3 3-3"/>@break
@case('menu')<path d="M4 7h16M4 12h16M4 17h16"/>@break
@case('x')<path d="m6 6 12 12M18 6 6 18"/>@break
@case('check')<path d="m5 12 4 4L19 6"/>@break
@case('bolt')<path d="m13 2-8 12h7l-1 8 8-12h-7z"/>@break
@case('chart')<path d="M4 20V10m6 10V4m6 16v-7m4 7H2"/>@break
@case('settings')<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1-2.8 2.8-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.6V21h-4v-.1a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.9.3l-.1.1L4.2 17l.1-.1a1.7 1.7 0 0 0 .3-1.9A1.7 1.7 0 0 0 3 14H3v-4h.1a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.3-1.9l-.1-.1L7 4.2l.1.1a1.7 1.7 0 0 0 1.9.3A1.7 1.7 0 0 0 10 3V3h4v.1a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.9-.3l.1-.1L19.8 7l-.1.1a1.7 1.7 0 0 0-.3 1.9 1.7 1.7 0 0 0 1.6 1H21v4h-.1a1.7 1.7 0 0 0-1.5 1z"/>@break
@default<circle cx="12" cy="12" r="9"/>@endswitch
</svg>
