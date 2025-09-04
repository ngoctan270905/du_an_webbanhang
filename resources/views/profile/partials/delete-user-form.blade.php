<section>
    <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Xóa tài khoản</div>
    <p class="mt-2 text-base text-gray-600 dark:text-gray-400">Khi tài khoản của bạn bị xóa, tất cả dữ liệu và tài nguyên liên quan sẽ bị xóa vĩnh viễn. Trước khi xóa tài khoản, vui lòng tải xuống bất kỳ dữ liệu hoặc thông tin nào bạn muốn giữ lại.</p>

    <x-danger-button 
        x-data="" 
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" 
        class="bg-red-600 hover:bg-red-700 text-white rounded-lg px-6 py-2.5 text-lg mt-4"
    >
        Xóa tài khoản
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Bạn có chắc chắn muốn xóa tài khoản?</h2>
            <p class="mt-2 text-base text-gray-600 dark:text-gray-400">Khi tài khoản của bạn bị xóa, tất cả dữ liệu và tài nguyên liên quan sẽ bị xóa vĩnh viễn. Vui lòng nhập mật khẩu để xác nhận bạn muốn xóa tài khoản vĩnh viễn.</p>

            <div class="mt-6">
                <x-input-label for="password" value="Mật khẩu" class="text-lg font-medium text-gray-900 dark:text-gray-100" />
                <x-text-input 
                    id="password" 
                    name="password" 
                    type="password" 
                    class="mt-1 block w-3/4 rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-lg py-3 px-4 focus:ring-indigo-500 focus:border-indigo-500" 
                    placeholder="Mật khẩu" 
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-base" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button 
                    x-on:click="$dispatch('close')" 
                    class="bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-900 dark:text-gray-100 rounded-lg px-6 py-2.5 text-lg"
                >
                    Hủy
                </x-secondary-button>
                <x-danger-button 
                    class="ms-3 bg-red-600 hover:bg-red-700 text-white rounded-lg px-6 py-2.5 text-lg"
                >
                    Xóa tài khoản
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>