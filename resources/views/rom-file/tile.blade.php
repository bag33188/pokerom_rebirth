@php
    $btnClassesStr = <<<'EOS'
    class="inline-flex items-center px-4 py-2 bg-blue-700 border
    border-transparent rounded-md font-semibold text-xs text-white
    uppercase tracking-widest hover:bg-blue-800 active:bg-blue-800
    focus:outline-none focus:border-blue-600 focus:ring focus:ring-blue-300
    disabled:opacity-25 transition"
    EOS;
    $tileClassesStr = <<<'EOS'
    class="border border-gray-200 bg-white shadow-md rounded w-full h-full
    inline-grid grid-cols-1 grid-rows-[auto_auto] gap-y-2 justify-self-center p-2"
    EOS;
    $eosRegExp = /** @lang RegExp */ "/([\r\n]+)|((?:\s{2,8})|\t+)/";

    // set pacific standard timezone
    date_default_timezone_set('PST8PDT');
@endphp
{{-- parameters:
    index (int),
    romFile (RomFile)
--}}
<div
    data-rom-file-id="{{$romFile->_id}}"
    id="tile-{{ $index + 1 }}"
    {!! preg_replace($eosRegExp, _SPACE, $tileClassesStr) !!}>
    <p>{{$romFile->filename}}</p>
    <p>{{$romFile->length}} Bytes</p>
    <p>Uploaded on {{parseDateAsReadableString($romFile->uploadDate, customFormat: 'm-d-Y, h:i:s A (T)')}}</p>
    <div class="justify-self-start align-self-end">
        <a href="{{route('rom-files.show', $romFile)}}"
            {!! preg_replace($eosRegExp, _SPACE, $btnClassesStr) !!}>Actions</a>
    </div>
</div>
