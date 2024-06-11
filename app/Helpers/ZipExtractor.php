<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;
use ZipArchive;
/**
 * ZipExtractor is a class that extracts the contents of zip file
 * and removes the zip file after extraction
 */

class ZipExtractor
{

    public static $destinationFolder;

    public static $zipFilePath;

    private static $supportedImageExtension = array('jpg', 'jpeg', 'png');


    public static function extractZip(string $destinationFolder, string $zipFilePath)
    {
        // set the static variables 
        self::$destinationFolder = storage_path('app/'. $destinationFolder);
        self::$zipFilePath = storage_path('app/'.$zipFilePath);
        // create a new instance of the class
        $instance = new self();

        try {
            // call the checkIFZipFileExists to verify if zip file
            // is of type zip and zip file in the zipFilePath exists
            $instance->checkIfZipFilePathExists();
            // call the checkIfDestinationFolderExists method to verify
            // if destination folder exists and if not create one
            $instance->checkIfDestinationFolderExists();
            // call the checkIfValidImageExtension if image inside
            // zip file are of valid image type
            $instance->checkIfValidImageExtension();
            // call the extractZipContents method to extract the 
            // zip contents to the destinationFolder
            $instance->extractZipContents();
            // call the removeZipFile method to remove the zip file
            $instance->removeZipFile();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function checkIfDestinationFolderExists()
    {
        if (!is_dir(self::$destinationFolder) && !file_exists(self::$destinationFolder)) {
            $makeDirectory = Storage::makeDirectory(self::$destinationFolder);
            if (!$makeDirectory) {
                Log::error("Destination Folder " . self::$destinationFolder . "could not be created.");
                throw new Exception("Destination Folder doesn't exist");
            }
        }
    }


    public function checkIfValidImageExtension()
    {
        $invalidImageExtensionFound = FALSE;
        $zipArchive = new ZipArchive();
        if ($zipArchive->open(self::$zipFilePath) == TRUE) {
            // Check each entry in the zip file
            for ($i = 0; $i < $zipArchive->numFiles; $i++) {
                $entryName = $zipArchive->getNameIndex($i);

                $extension = strtolower(pathinfo($entryName, PATHINFO_EXTENSION));

                if (!in_array($extension, self::$supportedImageExtension)) {
                    $invalidImageExtensionFound = TRUE;
                    break;
                }
            }

            // Close the zip file
            $zipArchive->close();
            // log and throw error if folder is found
            if ($invalidImageExtensionFound) {
                Log::error("Invalid Image Extension found inside the zip archive.");
                throw new Exception("Zip archive contains unsupported image extension. (Supported extension: jpg, jpeg, png)");
            }
        }
    }

    public function checkIfZipFilePathExists()
    {
        if (!file_exists(self::$zipFilePath)) {
            Log::error("Zip file " . self::$zipFilePath . " doesn't exist");
            throw new Exception("Zip File doesn't exist");
        }

        if (mime_content_type(self::$zipFilePath) != 'application/zip') {
            Log::error("Zip file " . self::$zipFilePath . "is not of valid extension");
            throw new Exception("Zip file is not of valid extension");
        }
    }

    public function extractZipContents()
    {
        $zipArchive = new ZipArchive();
        if ($zipArchive->open(self::$zipFilePath) == TRUE) {
            // Extract the zip contents to the destination folder
            $zipArchive->extractTo(self::$destinationFolder);
            // Close the zip file
            $zipArchive->close();
        }
    }

    public function removeZipFile()
    {
        $deleteZipFile = Storage::delete(self::$zipFilePath);
        if(!$deleteZipFile){
            Log::error("Failed to delete zip file " . self::$zipFilePath);
        }
    }
}
