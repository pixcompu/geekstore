<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 25/04/2016
 * Time: 07:06 PM
 */
class FileUploader{

    private $uploadFolder = '../../../resources/images/catalog/';
    private $uploadPath = 'resources/images/catalog/';
    private $uploadedFileURL;

    /**
     * @return string
     */
    public function getUploadFolder()
    {
        return $this->uploadFolder;
    }

    /**
     * @return mixed
     */
    public function getUploadedFileURL()
    {
        return $this->uploadedFileURL;
    }

    public function upload($nombreInput)
    {
        if($this->validateFileInput($nombreInput)){
            if($this->isValidFileExtension($nombreInput)){
                $imgName = basename($_FILES[$nombreInput]['name']);
                $urlArchivoPorSubir =
                    $this->uploadFolder . $imgName;

                if (move_uploaded_file($_FILES[$nombreInput]['tmp_name'], $urlArchivoPorSubir)) {
                    $this->uploadedFileURL = $this->uploadPath . $imgName;
                } else {
                    throw new Exception('Error al guardar el archivo');
                }
            }else{
                throw new Exception('Formato incorrecto');
            }
        }else{
            throw new Exception('Error al subir el archivo');
        }
    }

    public function isValidFileExtension($nombreInput)
    {
        $nombreArchivo = $_FILES[$nombreInput]['name'];

        $extension = strtolower(end(explode(".", $nombreArchivo)));

        $isJPG = (strcmp($extension, "jpg") == 0);
        $isPNG = (strcmp($extension, "png") == 0);
        $isJPEG = (strcmp($extension, "jpeg") == 0);
        $isMp4 = (strcmp($extension, "mp4") == 0);

        return ($isJPG || $isPNG || $isJPEG || $isMp4);
    }

    public function dumpFiles()
    {
        return array_map('unlink', glob($this->uploadFolder . "*"));
    }

    private function validateFileInput($inputName){
        return (isset($_FILES[$inputName]) || $_FILES[$inputName]['error'] == 0);
    }
}