<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard') - Admin Panel - {{ config('app.page_title') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&family=Roboto:wght@100;300;400;500;700;900&display=swap"
        rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/pages/admin/app.js'])
    @yield('head')
</head>

<body class="flex bg-skin-background text-skin-primary font-main">
    @include('layouts.inc.admin-sidebar')
    <main class="flex-grow max-w-full overflow-x-hidden">
        <nav class="flex h-admin-nav bg-skin-foreground border-b px-10 items-center relative">
            <button type="button" id="sidenav-opener" class="md:hidden mr-4 p-1 border rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 512 512">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10"
                        stroke-width="48" d="M88 152h336M88 256h336M88 360h336" />
                </svg>
                <div class="sr-only">Open Sidenav</div>
            </button>
            <div class="flex-grow"></div>
            <ul class="flex items-center space-x-3">
                <li>
                    <div class="px-4 py-3 flex items-center gap-1" title="{{ auth()->user()->email }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <g fill="none" fill-rule="evenodd">
                                <path
                                    d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z" />
                                <path fill="currentColor"
                                    d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10s10-4.477 10-10S17.523 2 12 2ZM8.5 9.5a3.5 3.5 0 1 1 7 0a3.5 3.5 0 0 1-7 0Zm9.758 7.484A7.985 7.985 0 0 1 12 20a7.985 7.985 0 0 1-6.258-3.016C7.363 15.821 9.575 15 12 15s4.637.821 6.258 1.984Z" />
                            </g>
                        </svg>
                        <h1 class="text-base font-bold">{{ auth()->user()->name }}</h1>
                    </div>
                </li>
                <li class="flex items-center pr-3">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" id="theme-toggle-switch" />
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden peer-checked:inline" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M12 18a6 6 0 1 1 0-12a6 6 0 0 1 0 12ZM11 1h2v3h-2V1Zm0 19h2v3h-2v-3ZM3.515 4.929l1.414-1.414L7.05 5.636L5.636 7.05L3.515 4.93ZM16.95 18.364l1.414-1.414l2.121 2.121l-1.414 1.414l-2.121-2.121Zm2.121-14.85l1.414 1.415l-2.121 2.121l-1.414-1.414l2.121-2.121ZM5.636 16.95l1.414 1.414l-2.121 2.121l-1.414-1.414l2.121-2.121ZM23 11v2h-3v-2h3ZM4 11v2H1v-2h3Z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 peer-checked:hidden" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M20.958 15.325c.204-.486-.379-.9-.868-.684a7.684 7.684 0 0 1-3.101.648c-4.185 0-7.577-3.324-7.577-7.425a7.28 7.28 0 0 1 1.134-3.91c.284-.448-.057-1.068-.577-.936C5.96 4.041 3 7.613 3 11.862C3 16.909 7.175 21 12.326 21c3.9 0 7.24-2.345 8.632-5.675Z" />
                            <path fill="currentColor"
                                d="M15.611 3.103c-.53-.354-1.162.278-.809.808l.63.945a2.332 2.332 0 0 1 0 2.588l-.63.945c-.353.53.28 1.162.81.808l.944-.63a2.332 2.332 0 0 1 2.588 0l.945.63c.53.354 1.162-.278.808-.808l-.63-.945a2.332 2.332 0 0 1 0-2.588l.63-.945c.354-.53-.278-1.162-.809-.808l-.944.63a2.332 2.332 0 0 1-2.588 0l-.945-.63Z" />
                        </svg>
                    </label>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="block">
                        @csrf
                        <button
                            class="flex gap-2 items-center px-4 py-2 rounded text-sm font-bold uppercase text-skin-inverted bg-skin-accent hover:bg-skin-accent-hover w-full text-left"
                            type="submit">
                            <span class="mt-1">Sign Out</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2">
                                    <path
                                        d="M14 8V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2v-2" />
                                    <path d="M9 12h12l-3-3m0 6l3-3" />
                                </g>
                            </svg>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
        <div class="p-4 md:p-8">
            @yield('page')
        </div>
    </main>
</body>

</html>
