@push('styles')
    <style <?= 'type="text/css"'; ?>>
        #files-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-gap: 1rem;
            margin: 1rem;
        }

        .files-grid-item {
            width: 100%;
            height: 100%;
            justify-self: center;
            align-self: center;
            border: 2px solid #333;
            border-radius: 4px;
            display: inline-grid;
            grid-template-columns: 1fr;
            grid-template-rows: auto auto;
            grid-row-gap: 8px;
        }

        .files-grid-item .files-actions-wrapper {
            justify-self: start;
            align-self: end
        }

        @media screen and (max-width: 1024px) {
            #files-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media screen and (max-width: 600px) {
            #files-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush
<x-app-layout>
    <x-slot name="header">
        <h2 style="text-align: center;">Pok&eacute;mon ROM Files</h2>
    </x-slot>
    <div id="files-grid">
        @foreach($romFiles as $romFile)
            <div class="files-grid-item">
                <p title="{{$romFile->_id}}">{{$romFile->filename}}</p>
                <div class="files-actions-wrapper">
                    <a href="{{route('rom-files.show', $romFile)}}" {!! JETSTREAM_BTN_CLASSES !!}>Actions</a>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
