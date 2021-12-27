<nav class="fixed left-0 top-16 bottom-0 z-50 w-14 bg-gray-800">
    <x-nav-link-sidebar :href="route('players.list')" :active="request()->routeIs('players.list')">
        <i class="fas fa-users"></i>
    </x-nav-link-sidebar>
    <x-nav-link-sidebar :href="route('permissions.list')" :active="request()->routeIs('permissions.list')">
        <i class="fas fa-user-check"></i>
    </x-nav-link-sidebar>
    <x-nav-link-sidebar :href="route('roles.list')" :active="request()->routeIs('roles.list')">
        <i class="fas fa-user-tag"></i>
    </x-nav-link-sidebar>
</nav>
