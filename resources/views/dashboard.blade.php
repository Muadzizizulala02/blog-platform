<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('The Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    

                    <div class="prose dark:prose-invert max-w-none text-lg leading-relaxed space-y-4">
                        <p>
                            Welcome to <strong>Muadz's Blog</strong>. Real talk? I mostly built this thing just to mess around with Laravel and see what breaks. It's basically my digital playground.
                        </p>

                        <p>
                            Expect some random thoughts, coding struggles, and whatever else pops into my head at anytime anywhere. It’s not that deep, just good vibes and some code. You know the drill. 🤷‍♂️
                        </p>

                        <div class="bg-yellow-50 dark:bg-yellow-900 border-l-4 border-yellow-400 dark:border-yellow-500 p-4 my-6 rounded-r-md">
                            <h4 class="text-lg font-bold text-yellow-800 dark:text-yellow-100 mb-2">
                                ⚠️ Heads Up: I barely tested this
                            </h4>
                            <p class="text-sm text-yellow-700 dark:text-yellow-200 mb-2">
                                I pushed this without running so much test. You might encounter some "features" such as:
                            </p>
                            <ul class="list-disc list-inside text-sm text-yellow-700 dark:text-yellow-200 space-y-1">
                                <li>Buttons that click but do absolutely nothing.</li>
                                <li>Dark mode might flash-bang your eyes unexpectedly.</li>
                                <li>If you find a bug, congrats! You found a feature. 🐛</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <h4 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">
                            Hit me up 📲
                        </h4>
                        <div class="flex flex-wrap gap-3">
                            <a href="mailto:muadzkhalid6@gmail.com" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                Email Me
                            </a>

                            <a href="https://www.linkedin.com/in/muadzkhalid" target="_blank" class="inline-flex items-center px-4 py-2 bg-[#0077b5] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#00669c] focus:outline-none focus:ring-2 focus:ring-[#0077b5] focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.063 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                LinkedIn
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>