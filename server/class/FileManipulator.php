<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 25/04/2016
 * Time: 07:06 PM
 */
class FileManipulator{

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
                    throw new SystemException(FIELD_NOT_VALID, 'Hubo un error al guardar la imagen');
                }
            }else{
                throw new SystemException(FIELD_NOT_VALID, 'Formato incorrecto, aceptamos sólo los siguientes formatos: JPG, PNG ó JPEG');
            }
        }else{
            throw new SystemException(FIELD_NOT_FOUND, 'Proporciona una imagen');
        }
    }

    public function isValidFileExtension($nombreInput)
    {
        $nombreArchivo = $_FILES[$nombreInput]['name'];

        $extension = strtolower(end(explode(".", $nombreArchivo)));

        $isJPG = (strcmp($extension, "jpg") == 0);
        $isPNG = (strcmp($extension, "png") == 0);
        $isJPEG = (strcmp($extension, "jpeg") == 0);


        return ($isJPG || $isPNG || $isJPEG);
    }

    public function dumpFiles()
    {
        return array_map('unlink', glob($this->uploadFolder . "*"));
    }

    private function validateFileInput($inputName){
        return (isset($_FILES[$inputName]) || $_FILES[$inputName]['error'] == 0);
    }
}