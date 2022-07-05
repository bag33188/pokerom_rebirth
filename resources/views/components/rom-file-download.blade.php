<form {{$attributes->merge(['class'=>'inline'])}}
      action="{{ route('rom-files.download', ['romFile' => $romFile]) }}"
      method="POST">
    @method('POST')
    @csrf

    @if($usePopupButtonStyle)
        <button
            type="submit"
            class="inline-flex items-center py-2 px-4 bg-blue-500 hover:bg-blue-400 text-white font-bold p-0 border-b-4 border-blue-700 hover:border-blue-500 rounded active:border-t-4 active:border-b-0 active:bg-blue-400"
        >
            <span class="order-0">@include('partials._download-icon')</span>
            <span class="order-1 ml-2">Download!</span>
        </button>
    @else
        <button
            type="submit"
            class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-teal-600 rounded-lg hover:bg-teal-500 focus:ring-4 focus:outline-none focus:ring-teal-400"
        >
            <span class="order-1">@include('partials._download-icon')</span>
            <span class="order-0 mr-2">Download!</span>
        </button>
    @endif
</form>
