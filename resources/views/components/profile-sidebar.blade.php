@props(['user'])

<div class="hidden md:w-1/4 md:block">
    <div class="py-4 px-4">
        <h2 class="text-lg font-semibold mb-4 dark:text-gray-200">User Profile</h2>
        <ul class="mb-4">
            <li class="ml-4 text-gray-600 transition-all duration-300 hover:translate-x-3 hover:text-blue-700 mb-2 dark:text-gray-300 dark:hover:text-blue-400">
                <a href="{{ route('profile', ['user' => $user->username]) }}">Profile Information</a>
            </li>
            <li class="ml-4 text-gray-600 transition-all duration-300 hover:translate-x-3 hover:text-blue-700 mb-2 dark:text-gray-300 dark:hover:text-blue-400">
                <a href="{{ route('profile.settings', ['user' => $user->username]) }}">Settings</a>
            </li>
            <li class="ml-4 text-gray-600 transition-all duration-300 hover:translate-x-3 hover:text-blue-700 mb-2 dark:text-gray-300 dark:hover:text-blue-400">
                <a href="{{ route('profile.help', ['user' => $user->username]) }}">Help</a>
            </li>
            <li class="ml-4 text-gray-600 transition-all duration-300 hover:translate-x-3 hover:text-blue-700 mb-2 dark:text-gray-300 dark:hover:text-blue-400">
                <a href="{{ route('profile.privacy', ['user' => $user->username]) }}">Privacy</a>
            </li>
        </ul>
    </div>
</div>