<x-error-layout>
    <div class="m-5" style="width: 60vw;">
        <div role="alert">
            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                Error
            </div>
            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700 text-center">
                <p>{!! $message !!}</p>
            </div>
        </div>
    </div>
</x-error-layout>
