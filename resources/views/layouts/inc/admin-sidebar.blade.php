<aside id="sidebar-main"
    class="hidden fixed h-full md:h-[100vh] z-10 md:sticky top-0 md:flex max-w-sm w-72 bg-skin-foreground flex-col px-3 border-r">
    <div class="h-admin-nav py-3 flex items-center collapsed:md:justify-center">
        <div class="flex-grow mx-2 collapsed:md:hidden whitespace-nowrap overflow-hidden">
            <h3 class="text-2xl font-bold">{{ config('app.name') }}</h3>
        </div>
        <button type="button" id="sidenav-resize"
            class="hidden md:block hover:text-active transition-all duration-100 rounded focus:ring-2">
            <div class="sr-only">Expand & Collapse Sidenav</div>
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"
                class="collapsed:hidden">
                <path fill="currentColor"
                    d="M3 18h13v-2H3v2zm0-5h10v-2H3v2zm0-7v2h13V6H3zm18 9.59L17.42 12L21 8.41L19.59 7l-5 5l5 5L21 15.59z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                class="hidden collapsed:block">
                <path fill="currentColor"
                    d="M3 6h10v2H3V6m0 10h10v2H3v-2m0-5h12v2H3v-2m13-4l-1.42 1.39L18.14 12l-3.56 3.61L16 17l5-5l-5-5Z" />
            </svg>
        </button>
        <button type="button" id="sidenav-closer" class="md:hidden">
            <div class="sr-only">Close sidenav</div>
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="m5 13l4 4l-1.4 1.42L1.18 12L7.6 5.58L9 7l-4 4h16v2H5m16-7v2H11V6h10m0 10v2H11v-2h10Z" />
            </svg>
        </button>
    </div>

    <nav class="flex-grow overflow-y-auto py-4">
        <ul class="collapsed:md:max-w-min mx-auto">
            <x-sidebar-item route="admin.index">
                <x-slot:svg>
                    <path fill="currentColor" d="M13 9V3h8v6h-8ZM3 13V3h8v10H3Zm10 8V11h8v10h-8ZM3 21v-6h8v6H3Z" />
                </x-slot:svg>
                Dashboard
            </x-sidebar-item>

            <x-sidebar-item route="items.add">
                <x-slot:svg viewBox="0 0 20 20">
                    <path fill="currentColor"
                        d="M11 9h4v2h-4v4H9v-4H5V9h4V5h2v4zm-1 11a10 10 0 1 1 0-20a10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16a8 8 0 0 0 0 16z" />
                </x-slot:svg>
                Add Item
            </x-sidebar-item>

        </ul>
    </nav>
</aside>
