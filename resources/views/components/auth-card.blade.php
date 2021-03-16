<div class="bg-hero min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-cover bg-no-repeat bg-center">
<style>
.bg-hero {
        background-image: url("{{ asset('images/member/login_bg.jpg') }}");
    }
</style>
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
