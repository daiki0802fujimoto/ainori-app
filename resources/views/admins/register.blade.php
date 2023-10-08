<x-app-layout>
    <x-slot name="header">
        <div class="custom_header">
            管理画面
        </div>
    </x-slot>
    <x-guest-layout>
        <form method="POST" action="{{ route('admin.store') }}">
            @csrf
    
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('名前')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="user[name]" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
    
            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('メールアドレス')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="user[email]" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
    
            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('パスワード')" />
    
                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="user[password]"
                                required autocomplete="new-password" />
    
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
    
            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('パスワード（確認）')" />
    
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="user[password_confirmation]" required autocomplete="new-password" />
    
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
            
            <!-- Age -->
            <div>
                <x-input-label for="age" :value="__('年齢')" />
                <x-text-input id="age" class="block mt-1 w-full" type="number" name="user[age]" :value="old('age')" required autofocus autocomplete="age" />
                <x-input-error :messages="$errors->get('age')" class="mt-2" />
            </div>
            
            <!-- Sex_id -->
            <div>
                <x-input-label for="sex_id" :value="__('性別')" />
                <x-text-input id="sex_id" type="radio" name="user[sex_id]" :value="1" required autofocus autocomplete="sex_id" />男性
                <x-text-input id="sex_id" type="radio" name="user[sex_id]" :value="2" required autofocus autocomplete="sex_id" />女性
                <x-input-error :messages="$errors->get('sex_id')" class="mt-2" />
            </div>
            
            
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>
</x-app-layout>