<x-error-layout>
    <div class="m-5 w-128">
        <div role="alert">
            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                <h6>Error</h6>
            </div>
            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700 text-center">
                <p>{!! $message ?? '<b>Oops, an unknown error occurred, please try again later.</b>' !!}</p>
            </div>
        </div>
    </div>
</x-error-layout>
