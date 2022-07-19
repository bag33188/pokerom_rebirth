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
@endphp
{{-- parameters:
    index (int),
    romFile (RomFile)
--}}
<div
    data-rom-file-id="{{$romFile->_id}}"
    id="tile-{{ $index + 1 }}"
    {!! preg_replace($eosRegExp, _SPACE, $tileClassesStr) !!}>
    <div class="p-2 border rounded-md shadow-sm border-gray-200 flex flex-col">
        <p class="inline-block"><code>{{$romFile->filename}}</code></p>
        <p class="inline-block"><code>{{$romFile->length}} Bytes</code></p>
        <p class="inline-flex flex-row">
            @php
                /**
                 * ## pacific standard timezone
                 * `PST, GMT-7`
                 * @var string $timeZonePST
                 */
                $timeZonePST = 'PST8PDT';
                /**
                 * ### `month-day-year hour:minute:second AM/PM (Time Zone, Daylight Savings)`
                 * @var string $upload_date_format
                 */
                $upload_date_format = 'm-d-Y, h:i:s A (T, I)';
                /** ### machine-readable `dateTime` format @var string $dtFormat */
                $dtFormat = 'Y-m-d G:i';
                // set time zone
                date_default_timezone_set($timeZonePST);
            @endphp
            <span class="font-semibold">Uploaded on</span>
            <span>&nbsp;</span>
            <time class="font-semibold"
                  datetime="{{ parseDateAsReadableString($romFile->uploadDate, format: $dtFormat) }}">
                {{ parseDateAsReadableString($romFile->uploadDate, format: $upload_date_format )}}
            </time>
        </p>
    </div>
    <div class="justify-self-start align-self-end pt-0.5">
        <a href="{{route('rom-files.show', $romFile)}}"
            {!! preg_replace($eosRegExp, _SPACE, $btnClassesStr) !!}>Actions</a>
    </div>
</div>
