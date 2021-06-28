<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <section class="text-gray-600 body-font">
                <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
                    <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 mb-10 md:mb-0">
                        <img class="object-cover object-center rounded" alt="hero" src="img/index_photo.png">
                    </div>
                    <div
                        class="lg:flex-grow md:w-1/2 lg:pl-24 md:pl-16 flex flex-col md:items-start md:text-left items-center text-center">
                        <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">歡迎使用
                            <br class="hidden lg:inline-block text-indigo-600">護生臨床推理問題導向學習系統
                        </h1>
                        <p class="mb-8 leading-relaxed">
                            使用這套系統可幫助你在一個情境中，透過解決問題的方式，了解自己不足需要加強的地方且加以修正，已正確面對未來在職場上可能會發生的各種問題。</p>
                        <div class="flex justify-center">
                            @auth
                                <div class="flex justify-center lg:justify-start mt-6">
                                    <a class="px-8 py-3 bg-indigo-600 text-gray-200 text-md font-semibold rounded hover:bg-gray-800"
                                        href="{{ route('homepage') }}">進入系統</a>
                                </div>
                            @else
                                <div class="flex justify-center lg:justify-start mt-6">
                                    <a class="px-4 py-3 bg-indigo-600 text-gray-200 text-md font-semibold rounded hover:bg-gray-800"
                                        href="{{ route('login') }}">進行登入</a>
                                    <a class="mx-4 px-4 py-3 bg-gray-300 text-gray-900 text-md font-semibold rounded hover:bg-gray-400"
                                        href="{{ route('register') }}">註冊</a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
