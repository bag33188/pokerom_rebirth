@if (session()->has('message'))
    <div class="bg-gray-100 border-t-4 border-red-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
         role="alert">
        <div class="flex">
            <div>
                <p class="text-sm">{{ session('message') }}</p>
            </div>
        </div>
    </div>
@endif
