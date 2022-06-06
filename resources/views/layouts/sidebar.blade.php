<nav class="fixed left-0 top-16 bottom-0 z-10 w-14 bg-gray-800">
    @can('player-crud')
        <x-nav-link-sidebar :href="route('players.list')" :active="request()->is('players*')">
            <i class="fa-solid fa-user-group"></i>
        </x-nav-link-sidebar>
    @endcan
    @can('permission-crud')
        <x-nav-link-sidebar :href="route('permissions.list')" :active="request()->is('permissions*')">
            <i class="fas fa-user-check"></i>
        </x-nav-link-sidebar>
    @endcan
    @can('role-crud')
        <x-nav-link-sidebar :href="route('roles.list')" :active="request()->is('roles*')">
            <i class="fas fa-user-tag"></i>
        </x-nav-link-sidebar>
    @endcan
    @can('festival-create')
        <x-nav-link-sidebar :href="route('anim.grids.rewards.list')" :active="request()->is('anim/grid-rewards*')">
            <i class="fa-solid fa-chess-board"></i>
        </x-nav-link-sidebar>
    @elsecan('festival-edit', 'festival-show')
        <x-nav-link-sidebar :href="route('anim.grids.rewards.list')" :active="request()->is('anim/grid-rewards*')">
            <i class="fa-solid fa-chess-board"></i>
        </x-nav-link-sidebar>
    @endcan
    @can('code-crud')
        <x-nav-link-sidebar :href="route('anim.decode.list')" :active="request()->is('anim/decode*')">
            <i class="fa-solid fa-lock"></i>
        </x-nav-link-sidebar>
    @endcan
</nav>
