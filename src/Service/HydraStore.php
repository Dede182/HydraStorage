<?php

namespace HydraStorage\HydraStorage\Service;

use HydraStorage\HydraStorage\Service\Option\MediaOption;
use Illuminate\Support\Facades\Storage;

class HydraStore {

    protected $mediaOption;

    protected $mainPath = 'public/';

    public function __construct( MediaOption $mediaOption = null ) {
        $this->mediaOption = $mediaOption ?? app( 'mediaOption' );
    }

    public function storeMedia( mixed $file, string $folderPath = 'media', bool $compression = false ) {
        $mediaCollection = $compression ? $this->manipulate( $file ) : $file;
        $this->createStorageFolder( $folderPath );

        $output = [];

        if ( is_array( $mediaCollection ) ) {
            foreach ( $mediaCollection as $media ) {
                $output[] = $this->store( $folderPath, $media );
            }
        } else {
            return $this->store( $folderPath, $mediaCollection );

        }
        return $output;
    }

    protected function manipulate( string|array $file ) : string|array {
        return ImageManipulation::manipulate( $file );
    }

    protected function store( $path, $file ) {
        $disk = config( 'hydrastorage.provider' );
        $file_name = time().str_replace( ' ', '_', $file->getClientOriginalName() );

        Storage::disk( $disk )->put( $this->mainPath.$path.'/'.$file_name, file_get_contents( $file ) );

        return $file_name;
    }

    protected function createStorageFolder( string $folderPath ) {
        if ( !Storage::exists( $this->mainPath.$folderPath ) ) {
            Storage::makeDirectory( $this->mainPath.$folderPath, 0755, true );
        }
    }

}
