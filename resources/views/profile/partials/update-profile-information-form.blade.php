<section>
    <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Thông tin cá nhân</div>
    <p class="mt-2 text-base text-gray-600 dark:text-gray-400">Cập nhật thông tin cá nhân và địa chỉ email của tài khoản.</p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="'Họ và tên'" class="text-lg font-medium text-gray-900 dark:text-gray-100" />
            <x-text-input 
                id="name" 
                name="name" 
                type="text" 
                class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-lg py-3 px-4 focus:ring-indigo-500 focus:border-indigo-500" 
                :value="old('name', $user->name)" 
                required 
                autofocus 
                autocomplete="name" 
            />
            <x-input-error class="mt-2 text-base" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="'Email'" class="text-lg font-medium text-gray-900 dark:text-gray-100" />
            <x-text-input 
                id="email" 
                name="email" 
                type="email" 
                class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-lg py-3 px-4 focus:ring-indigo-500 focus:border-indigo-500" 
                :value="old('email', $user->email)" 
                required 
                autocomplete="username" 
            />
            <x-input-error class="mt-2 text-base" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-base mt-2 text-gray-800 dark:text-gray-200">
                        Địa chỉ email của bạn chưa được xác minh.
                        <button 
                            form="send-verification" 
                            class="underline text-base text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        >
                            Nhấn vào đây để gửi lại email xác minh.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-base text-green-600 dark:text-green-400">
                            Một liên kết xác minh mới đã được gửi đến địa chỉ email của bạn.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-6 py-2.5 text-lg">Lưu</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p 
                    x-data="{ show: true }" 
                    x-show="show" 
                    x-transition 
                    x-init="setTimeout(() => show = false, 2000)" 
                    class="text-base text-gray-600 dark:text-gray-400"
                >Đã lưu.</p>
            @endif
        </div>
    </form>
</section>