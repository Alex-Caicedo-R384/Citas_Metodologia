<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chat with ') }} 
            {{ $chat->user1->name == auth()->user()->name ? $chat->user2->name : $chat->user1->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                <div class="space-y-4">
                    @foreach($messages as $message)
                        <div class="flex items-center">
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                <span class="font-semibold">{{ $message->user->name }}:</span> 
                                {{ $message->content }}
                            </div>
                            <div class="text-xs text-gray-500 ml-2">{{ $message->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    @endforeach
                </div>

                <form method="POST" action="{{ route('chat.send', $chat->id) }}" class="mt-4">
                    @csrf
                    <textarea name="message" class="w-full p-2 border rounded-md" rows="3" placeholder="Type your message..." required></textarea>
                    <button type="submit" class="mt-2 bg-blue-600 text-white p-2 rounded-md">Send</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
