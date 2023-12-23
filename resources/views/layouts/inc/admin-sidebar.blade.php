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

            <x-sidebar-item route="items.stock">
                <x-slot:svg viewBox="0 0 16 16">
                    <path fill="currentColor"
                        d="M12.9 2.5C11.3 1.3 11.5 0 11.5 0H2v12.5C2 14.4 4.1 16 6 16h8V3s-.8-.2-1.1-.5M7 6.3c-.9-.3-2.3-.8-2.3-1.9C4.8 3.6 6 3 6 2.8V2h1v.7c1 .1 1.8.4 1.9.4l-.3.9s-.7-.3-1.5-.3c-.7 0-1.1.3-1.2.8c0 .3.5.6 1.3.9c1.5.5 1.9 1.1 1.9 1.9C9.1 8 9 8.9 7 9.1v.9H6v-.8c0-.1-1.4-.5-1.5-.5l.5-.9s1.1.5 2 .4s1.3-.6 1.3-1c.1-.3-.4-.6-1.3-.9m6 8.7H6c-1 0-1.8-.6-2-1.3c-.1-.3 0-.7.4-.7H11V2.7c1 .6 2 1.1 2 1.3z" />
                </x-slot:svg>
                Stock
            </x-sidebar-item>

            <x-sidebar-item route="sales.add">
                <x-slot:svg viewBox="0 0 20 20">
                    <path fill="currentColor"
                        d="M11 9h4v2h-4v4H9v-4H5V9h4V5h2v4zm-1 11a10 10 0 1 1 0-20a10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16a8 8 0 0 0 0 16z" />
                </x-slot:svg>
                Add Sale
            </x-sidebar-item>
            <x-sidebar-item route="sales.index">
                <x-slot:svg viewBox="0 0 48 48">
                    <g fill="none">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                            d="M5 17h38l-4.2 26H9.2zm30 0c0-6.627-4.925-12-11-12s-11 5.373-11 12" />
                        <circle cx="17" cy="26" r="2" fill="currentColor" />
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                            d="M18 33s2 3 6 3s6-3 6-3" />
                        <circle cx="31" cy="26" r="2" fill="currentColor" />
                    </g>
                </x-slot:svg>
                Sales List
            </x-sidebar-item>

            
            <x-sidebar-item route="settings.index">
                <x-slot:svg viewBox="0 0 24 24">
                    <path fill="currentColor" d="M12 15.5A3.5 3.5 0 0 1 8.5 12A3.5 3.5 0 0 1 12 8.5a3.5 3.5 0 0 1 3.5 3.5a3.5 3.5 0 0 1-3.5 3.5m7.43-2.53c.04-.32.07-.64.07-.97c0-.33-.03-.66-.07-1l2.11-1.63c.19-.15.24-.42.12-.64l-2-3.46c-.12-.22-.39-.31-.61-.22l-2.49 1c-.52-.39-1.06-.73-1.69-.98l-.37-2.65A.506.506 0 0 0 14 2h-4c-.25 0-.46.18-.5.42l-.37 2.65c-.63.25-1.17.59-1.69.98l-2.49-1c-.22-.09-.49 0-.61.22l-2 3.46c-.13.22-.07.49.12.64L4.57 11c-.04.34-.07.67-.07 1c0 .33.03.65.07.97l-2.11 1.66c-.19.15-.25.42-.12.64l2 3.46c.12.22.39.3.61.22l2.49-1.01c.52.4 1.06.74 1.69.99l.37 2.65c.04.24.25.42.5.42h4c.25 0 .46-.18.5-.42l.37-2.65c.63-.26 1.17-.59 1.69-.99l2.49 1.01c.22.08.49 0 .61-.22l2-3.46c.12-.22.07-.49-.12-.64z"/>
                </x-slot:svg>
                Settings
            </x-sidebar-item>


        </ul>
    </nav>
</aside>
