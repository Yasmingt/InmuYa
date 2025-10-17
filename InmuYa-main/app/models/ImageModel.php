<?php
/**
 * Modelo de Imágenes
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja todas las operaciones relacionadas con imágenes de propiedades
 */

class ImageModel {
    private $conexion;
    private $uploadPath;
    
    public function __construct() {
        // Incluir la conexión a la base de datos
        $conexionPath = __DIR__ . '/../../config/conexion.php';
        
        if (!file_exists($conexionPath)) {
            throw new Exception("Error: No se encontró el archivo de conexión en: " . $conexionPath);
        }
        
        require_once $conexionPath;
        
        // Obtener la conexión
        if (isset($conexion)) {
            $this->conexion = $conexion;
        } elseif (isset($GLOBALS['conexion'])) {
            $this->conexion = $GLOBALS['conexion'];
        } else {
            throw new Exception("Error: No se pudo obtener la conexión a la base de datos");
        }
        
        // Verificar que la conexión se estableció correctamente
        if (!$this->conexion || $this->conexion->connect_error) {
            throw new Exception("Error: No se pudo establecer la conexión a la base de datos");
        }
        
        // Configurar ruta de subida
        $this->uploadPath = __DIR__ . '/../../public/img/propiedades/';
        
        // Crear directorio si no existe
        if (!file_exists($this->uploadPath)) {
            mkdir($this->uploadPath, 0755, true);
        }
    }
    
    /**
     * Obtener todas las imágenes de una propiedad
     */
    public function getImagesByProperty($propertyId) {
        $sql = "SELECT * FROM imagenes 
                WHERE id_propiedad = ? AND activo = 1 
                ORDER BY es_principal DESC, orden ASC, fecha_subida ASC";
        
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
        }
        
        $stmt->bind_param("i", $propertyId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $images = [];
        while ($row = $result->fetch_assoc()) {
            $images[] = $row;
        }
        
        return $images;
    }
    
    /**
     * Obtener imagen principal de una propiedad
     */
    public function getMainImage($propertyId) {
        $sql = "SELECT * FROM imagenes 
                WHERE id_propiedad = ? AND es_principal = 1 AND activo = 1 
                LIMIT 1";
        
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
        }
        
        $stmt->bind_param("i", $propertyId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return false;
    }
    
    /**
     * Subir múltiples imágenes
     */
    public function uploadImages($propertyId, $files, $data = []) {
        $uploadedImages = [];
        $errors = [];
        
        // Validar que hay archivos
        if (empty($files['name'][0])) {
            throw new Exception("No se seleccionaron archivos para subir");
        }
        
        // Procesar cada archivo
        for ($i = 0; $i < count($files['name']); $i++) {
            if ($files['error'][$i] === UPLOAD_ERR_OK) {
                try {
                    $imageData = $this->processImage($files, $i, $propertyId);
                    $imageId = $this->saveImageToDatabase($propertyId, $imageData, $data);
                    $uploadedImages[] = $imageId;
                } catch (Exception $e) {
                    $errors[] = "Error en archivo " . ($i + 1) . ": " . $e->getMessage();
                }
            } else {
                $errors[] = "Error en archivo " . ($i + 1) . ": " . $this->getUploadError($files['error'][$i]);
            }
        }
        
        return [
            'success' => count($uploadedImages) > 0,
            'uploaded_images' => $uploadedImages,
            'errors' => $errors
        ];
    }
    
    /**
     * Procesar una imagen individual
     */
    private function processImage($files, $index, $propertyId) {
        $fileName = $files['name'][$index];
        $fileTmpName = $files['tmp_name'][$index];
        $fileSize = $files['size'][$index];
        $fileType = $files['type'][$index];
        
        // Validar tipo de archivo
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($fileType, $allowedTypes)) {
            throw new Exception("Tipo de archivo no permitido: " . $fileType);
        }
        
        // Validar tamaño (máximo 5MB)
        $maxSize = 5 * 1024 * 1024; // 5MB
        if ($fileSize > $maxSize) {
            throw new Exception("El archivo es demasiado grande. Máximo 5MB");
        }
        
        // Generar nombre único
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $uniqueName = 'prop_' . $propertyId . '_' . time() . '_' . $index . '.' . $extension;
        
        // Crear directorio por propiedad si no existe
        $propertyDir = $this->uploadPath . 'propiedad_' . $propertyId . '/';
        if (!file_exists($propertyDir)) {
            mkdir($propertyDir, 0755, true);
        }
        
        $uploadPath = $propertyDir . $uniqueName;
        
        // Mover archivo
        if (!move_uploaded_file($fileTmpName, $uploadPath)) {
            throw new Exception("Error al mover el archivo");
        }
        
        // Crear miniaturas
        $this->createThumbnails($uploadPath, $propertyDir, $uniqueName);
        
        return [
            'original_name' => $fileName,
            'saved_name' => $uniqueName,
            'path' => $uploadPath,
            'relative_path' => 'propiedades/propiedad_' . $propertyId . '/' . $uniqueName,
            'size' => $fileSize,
            'type' => $fileType
        ];
    }
    
    /**
     * Crear miniaturas de la imagen
     */
    private function createThumbnails($originalPath, $directory, $fileName) {
        $imageInfo = getimagesize($originalPath);
        if (!$imageInfo) {
            return;
        }
        
        $width = $imageInfo[0];
        $height = $imageInfo[1];
        $type = $imageInfo[2];
        
        // Crear imagen desde archivo
        switch ($type) {
            case IMAGETYPE_JPEG:
                $sourceImage = imagecreatefromjpeg($originalPath);
                break;
            case IMAGETYPE_PNG:
                $sourceImage = imagecreatefrompng($originalPath);
                break;
            case IMAGETYPE_GIF:
                $sourceImage = imagecreatefromgif($originalPath);
                break;
            case IMAGETYPE_WEBP:
                $sourceImage = imagecreatefromwebp($originalPath);
                break;
            default:
                return;
        }
        
        // Crear miniatura grande (800x600)
        $this->createThumbnail($sourceImage, $directory . 'thumb_' . $fileName, 800, 600, $width, $height);
        
        // Crear miniatura pequeña (300x200)
        $this->createThumbnail($sourceImage, $directory . 'small_' . $fileName, 300, 200, $width, $height);
        
        imagedestroy($sourceImage);
    }
    
    /**
     * Crear una miniatura específica
     */
    private function createThumbnail($sourceImage, $outputPath, $maxWidth, $maxHeight, $originalWidth, $originalHeight) {
        // Calcular dimensiones manteniendo proporción
        $ratio = min($maxWidth / $originalWidth, $maxHeight / $originalHeight);
        $newWidth = intval($originalWidth * $ratio);
        $newHeight = intval($originalHeight * $ratio);
        
        // Crear imagen de destino
        $thumbnail = imagecreatetruecolor($newWidth, $newHeight);
        
        // Preservar transparencia para PNG
        imagealphablending($thumbnail, false);
        imagesavealpha($thumbnail, true);
        
        // Redimensionar
        imagecopyresampled($thumbnail, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
        
        // Guardar miniatura
        $extension = pathinfo($outputPath, PATHINFO_EXTENSION);
        switch (strtolower($extension)) {
            case 'jpg':
            case 'jpeg':
                imagejpeg($thumbnail, $outputPath, 85);
                break;
            case 'png':
                imagepng($thumbnail, $outputPath, 8);
                break;
            case 'gif':
                imagegif($thumbnail, $outputPath);
                break;
            case 'webp':
                imagewebp($thumbnail, $outputPath, 85);
                break;
        }
        
        imagedestroy($thumbnail);
    }
    
    /**
     * Guardar información de imagen en la base de datos
     */
    private function saveImageToDatabase($propertyId, $imageData, $data = []) {
        $sql = "INSERT INTO imagenes (
            id_propiedad, url_imagen, titulo, descripcion, 
            orden, es_principal, activo
        ) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
        }
        
        $titulo = $data['titulo'] ?? $imageData['original_name'];
        $descripcion = $data['descripcion'] ?? '';
        $orden = $data['orden'] ?? 0;
        $esPrincipal = isset($data['es_principal']) ? 1 : 0;
        
        $stmt->bind_param("isssiii", 
            $propertyId,
            $imageData['relative_path'],
            $titulo,
            $descripcion,
            $orden,
            $esPrincipal,
            1
        );
        
        if (!$stmt->execute()) {
            throw new Exception("Error al guardar la imagen en la base de datos: " . $stmt->error);
        }
        
        return $stmt->insert_id;
    }
    
    /**
     * Eliminar imagen
     */
    public function deleteImage($imageId) {
        // Obtener información de la imagen
        $image = $this->getImageById($imageId);
        if (!$image) {
            throw new Exception("Imagen no encontrada");
        }
        
        // Eliminar archivos físicos
        $this->deleteImageFiles($image['url_imagen']);
        
        // Marcar como inactiva en la base de datos
        $sql = "UPDATE imagenes SET activo = 0 WHERE id_imagen = ?";
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
        }
        
        $stmt->bind_param("i", $imageId);
        
        return $stmt->execute();
    }
    
    /**
     * Obtener imagen por ID
     */
    public function getImageById($imageId) {
        $sql = "SELECT * FROM imagenes WHERE id_imagen = ? AND activo = 1";
        
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
        }
        
        $stmt->bind_param("i", $imageId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return false;
    }
    
    /**
     * Marcar imagen como principal
     */
    public function setMainImage($imageId, $propertyId) {
        // Primero quitar principal de todas las imágenes de la propiedad
        $sql = "UPDATE imagenes SET es_principal = 0 WHERE id_propiedad = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $propertyId);
        $stmt->execute();
        
        // Marcar la nueva imagen como principal
        $sql = "UPDATE imagenes SET es_principal = 1 WHERE id_imagen = ? AND id_propiedad = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ii", $imageId, $propertyId);
        
        return $stmt->execute();
    }
    
    /**
     * Actualizar orden de imágenes
     */
    public function updateImageOrder($imageId, $newOrder) {
        $sql = "UPDATE imagenes SET orden = ? WHERE id_imagen = ?";
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
        }
        
        $stmt->bind_param("ii", $newOrder, $imageId);
        
        return $stmt->execute();
    }
    
    /**
     * Eliminar archivos físicos de imagen
     */
    private function deleteImageFiles($relativePath) {
        $basePath = __DIR__ . '/../../public/img/';
        $fullPath = $basePath . $relativePath;
        
        // Eliminar archivo original
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
        
        // Eliminar miniaturas
        $pathInfo = pathinfo($fullPath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'];
        
        $thumbPath = $directory . '/thumb_' . $filename . '.' . $extension;
        $smallPath = $directory . '/small_' . $filename . '.' . $extension;
        
        if (file_exists($thumbPath)) {
            unlink($thumbPath);
        }
        
        if (file_exists($smallPath)) {
            unlink($smallPath);
        }
    }
    
    /**
     * Obtener error de subida
     */
    private function getUploadError($errorCode) {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return "El archivo excede el tamaño máximo permitido por el servidor";
            case UPLOAD_ERR_FORM_SIZE:
                return "El archivo excede el tamaño máximo permitido por el formulario";
            case UPLOAD_ERR_PARTIAL:
                return "El archivo fue subido parcialmente";
            case UPLOAD_ERR_NO_FILE:
                return "No se seleccionó ningún archivo";
            case UPLOAD_ERR_NO_TMP_DIR:
                return "No se encontró el directorio temporal";
            case UPLOAD_ERR_CANT_WRITE:
                return "No se pudo escribir el archivo al disco";
            case UPLOAD_ERR_EXTENSION:
                return "La subida fue detenida por una extensión";
            default:
                return "Error desconocido en la subida";
        }
    }
    
    /**
     * Obtener estadísticas de imágenes
     */
    public function getImageStats($propertyId = null) {
        $sql = "SELECT COUNT(*) as total FROM imagenes WHERE activo = 1";
        $params = [];
        $types = "";
        
        if ($propertyId) {
            $sql .= " AND id_propiedad = ?";
            $params[] = $propertyId;
            $types .= "i";
        }
        
        $stmt = $this->conexion->prepare($sql);
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc()['total'];
    }
}
?>
