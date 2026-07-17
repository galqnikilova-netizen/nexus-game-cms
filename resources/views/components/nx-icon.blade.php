@props(['name'])
@switch($name)
@case('home')<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 11.5 12 4l9 7.5"/><path d="M5.5 10v9h13v-9M9 19v-5h6v5"/></svg>@break
@case('servers')<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="4" y="4" width="16" height="6" rx="2"/><rect x="4" y="14" width="16" height="6" rx="2"/><path d="M8 7h.01M8 17h.01M12 7h5M12 17h5"/></svg>@break
@case('community')<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M16 20v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/><circle cx="9.5" cy="7" r="3"/><path d="M16 4.5a3 3 0 0 1 0 5.5M21 20v-2a4 4 0 0 0-3-3.65"/></svg>@break
@case('shop')<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 9h14l-1 11H6L5 9Z"/><path d="M9 10V7a3 3 0 0 1 6 0v3"/></svg>@break
@case('bans')<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="8"/><path d="m6.5 17.5 11-11"/></svg>@break
@case('news')<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="4" y="4" width="16" height="16" rx="2"/><path d="M8 8h5M8 12h8M8 16h8"/></svg>@break
@case('search')<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="11" cy="11" r="6"/><path d="m16 16 4 4"/></svg>@break
@case('more')<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="5" cy="12" r="1" fill="currentColor"/><circle cx="12" cy="12" r="1" fill="currentColor"/><circle cx="19" cy="12" r="1" fill="currentColor"/></svg>@break
@case('user')<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="8" r="4"/><path d="M4.5 21a7.5 7.5 0 0 1 15 0"/></svg>@break
@case('dashboard')<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="4" y="4" width="6" height="6" rx="1"/><rect x="14" y="4" width="6" height="6" rx="1"/><rect x="4" y="14" width="6" height="6" rx="1"/><rect x="14" y="14" width="6" height="6" rx="1"/></svg>@break
@case('users')<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="9" cy="8" r="3"/><path d="M3 20v-2a5 5 0 0 1 5-5h2a5 5 0 0 1 5 5v2M16 5.5a3 3 0 0 1 0 5.5M21 20v-2a5 5 0 0 0-3.4-4.74"/></svg>@break
@case('roles')<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 3 4.5 6v5c0 4.8 3.1 8 7.5 10 4.4-2 7.5-5.2 7.5-10V6L12 3Z"/><path d="m9 12 2 2 4-4"/></svg>@break
@case('modules')<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M8 3v4M16 3v4M7 7h10v4a5 5 0 0 1-10 0V7ZM12 16v5"/></svg>@break
@case('settings')<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-2.83 2.83-.06-.06a1.7 1.7 0 0 0-1.88-.34 1.7 1.7 0 0 0-1.03 1.56V21h-4v-.09A1.7 1.7 0 0 0 9 19.36a1.7 1.7 0 0 0-1.88.34l-.06.06-2.83-2.83.06-.06A1.7 1.7 0 0 0 4.63 15 1.7 1.7 0 0 0 3.08 14H3v-4h.09A1.7 1.7 0 0 0 4.64 9a1.7 1.7 0 0 0-.34-1.88l-.06-.06 2.83-2.83.06.06A1.7 1.7 0 0 0 9 4.63 1.7 1.7 0 0 0 10 3.08V3h4v.09A1.7 1.7 0 0 0 15 4.64a1.7 1.7 0 0 0 1.88-.34l.06-.06 2.83 2.83-.06.06A1.7 1.7 0 0 0 19.37 9 1.7 1.7 0 0 0 20.92 10H21v4h-.09A1.7 1.7 0 0 0 19.4 15Z"/></svg>@break
@case('logout')<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M10 5H5v14h5M14 8l4 4-4 4M8 12h10"/></svg>@break
@case('external')<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 5h5v5M19 5l-8 8"/><path d="M18 13v6H5V6h6"/></svg>@break
@default<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="8"/></svg>
@endswitch
