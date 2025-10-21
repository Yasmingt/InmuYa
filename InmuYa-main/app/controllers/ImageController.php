<?php
/**
 * Controlador de Imágenes
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja la lógica de gestión de imágenes de propiedades
 */

class ImageController {
    private $imageModel;
    
    public function __construct() {
        // Incluir el modelo de imágenes
        require_once __DIR__ . '/../models/ImageModel.php';
        $this->imageModel = new ImageModel();
        
        // Verificar acceso de administrador
        $this->checkAdminAccess();
    }
    
    /**
     * Verificar acceso de administrador
     */
    private function checkAdminAccess() {
        session_start();
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }
        
        if ($_SESSION['user_type'] !== 'admin') {
            header('Location: ' . BASE_URL);
            exit;
        }
    }
    
    /**
     * Mostrar gestión de imágenes de una propiedad
     */
    public function gestionarImagenes($propertyId) {
        // Obtener información de la propiedad
        require_once __DIR__ . '/../models/PropertyModel.php';
        $propertyModel = new PropertyModel();
        $propiedad = $propertyModel->getPropertyById($propertyId);
        
        if (!$propiedad) {
            $_SESSION['error_message'] = 'Propiedad no encontrada';
            header('Location: ' . BASE_URL . 'admin/propiedades');
            exit;
        }
        
        // Obtener imágenes de la propiedad
        $imagenes = $this->imageModel->getImagesByProperty($propertyId);
        
        // Incluir la vista
        include __DIR__ . '/../views/admin/propiedad/gestionarImagenes.php';
    }
    
    /**
     * Subir imágenes
     */
    public function subirImagenes($propertyId) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'admin/gestionar-imagenes/' . $propertyId);
            exit;
        }
        
        try {
            // Validar que hay archivos
            if (empty($_FILES['imagenes']['name'][0])) {
                throw new Exception('No se seleccionaron archivos para subir');
            }
            
            // Procesar datos adicionales
            $data = [
                'titulo' => $_POST['titulo'] ?? '',
                'descripcion' => $_POST['descripcion'] ?? '',
                'es_principal' => isset($_POST['es_principal']),
                'orden' => $_POST['orden'] ?? 0
            ];
            
            // Subir imágenes
            $result = $this->imageModel->uploadImages($propertyId, $_FILES['imagenes'], $data);
            
            if ($result['success']) {
                $_SESSION['success_message'] = 'Imágenes subidas exitosamente';
                
                // Mostrar errores si los hay
                if (!empty($result['errors'])) {
                    $_SESSION['warning_message'] = 'Algunas imágenes no se pudieron subir: ' . implode(', ', $result['errors']);
                }
            } else {
                throw new Exception('No se pudieron subir las imágenes: ' . implode(', ', $result['errors']));
            }
            
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Error al subir imágenes: ' . $e->getMessage();
        }
        
        header('Location: ' . BASE_URL . 'admin/gestionar-imagenes/' . $propertyId);
        exit;
    }
    
    /**
     * Eliminar imagen
     */
    public function eliminarImagen($imageId) {
        try {
            // Verificar que sea una petición AJAX
            if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
                throw new Exception('Petición no válida');
            }
            
            $this->imageModel->deleteImage($imageId);
            
            $response = [
                'success' => true,
                'message' => 'Imagen eliminada exitosamente'
            ];
            
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'error' => 'Error al eliminar imagen: ' . $e->getMessage()
            ];
        }
        
        // Enviar respuesta JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    
    /**
     * Marcar imagen como principal
     */
    public function marcarPrincipal($imageId) {
        try {
            // Obtener información de la imagen para saber a qué propiedad pertenece
            $imagen = $this->imageModel->getImageById($imageId);
            
            if (!$imagen) {
                throw new Exception('Imagen no encontrada');
            }
            
            $this->imageModel->setMainImage($imageId, $imagen['id_propiedad']);
            $_SESSION['success_message'] = 'Imagen marcada como principal';
            
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Error al marcar imagen como principal: ' . $e->getMessage();
        }
        
        // Redirigir de vuelta
        $referer = $_SERVER['HTTP_REFERER'] ?? BASE_URL . 'admin/propiedades';
        header('Location: ' . $referer);
        exit;
    }
    
    /**
     * Actualizar orden de imágenes
     */
    public function actualizarOrden() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            exit;
        }
        
        try {
            $imageOrders = $_POST['image_orders'] ?? [];
            
            foreach ($imageOrders as $imageId => $order) {
                $this->imageModel->updateImageOrder($imageId, $order);
            }
            
            echo json_encode(['success' => true, 'message' => 'Orden actualizado correctamente']);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error al actualizar orden: ' . $e->getMessage()]);
        }
        
        exit;
    }
    
    /**
     * Obtener imágenes de una propiedad (AJAX)
     */
    public function obtenerImagenes($propertyId) {
        try {
            $imagenes = $this->imageModel->getImagesByProperty($propertyId);
            
            // Agregar URL completa a cada imagen
            foreach ($imagenes as &$imagen) {
                $imagen['url_completa'] = BASE_URL . 'public/img/' . $imagen['url_imagen'];
            }
            
            echo json_encode([
                'success' => true,
                'images' => $imagenes
            ]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener imágenes: ' . $e->getMessage()
            ]);
        }
        
        exit;
    }
    
    /**
     * Guardar imágenes nuevas para una propiedad
     */
    public function guardarImagenes() {
        try {
            // Verificar que sea una petición POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }
            
            // Verificar que hay imágenes
            if (!isset($_FILES['imagenes']) || empty($_FILES['imagenes']['name'][0])) {
                throw new Exception('No se han seleccionado imágenes');
            }
            
            // Obtener ID de la propiedad
            $propiedadId = $_POST['propiedad_id'] ?? null;
            if (!$propiedadId) {
                throw new Exception('ID de propiedad no especificado');
            }
            
            // Procesar imágenes
            $imagenesGuardadas = 0;
            $errores = [];
            
            foreach ($_FILES['imagenes']['name'] as $index => $filename) {
                if (empty($filename)) continue;
                
                $fileData = [
                    'name' => $_FILES['imagenes']['name'][$index],
                    'type' => $_FILES['imagenes']['type'][$index],
                    'tmp_name' => $_FILES['imagenes']['tmp_name'][$index],
                    'error' => $_FILES['imagenes']['error'][$index],
                    'size' => $_FILES['imagenes']['size'][$index]
                ];
                
                try {
                    // Subir imagen
                    $resultado = $this->imageModel->uploadImages([$fileData], $propiedadId);
                    if ($resultado['success']) {
                        $imagenesGuardadas++;
                    } else {
                        $errores[] = $resultado['error'];
                    }
                } catch (Exception $e) {
                    $errores[] = $e->getMessage();
                }
            }
            
            // Preparar respuesta
            $response = [
                'success' => $imagenesGuardadas > 0,
                'count' => $imagenesGuardadas,
                'errors' => $errores
            ];
            
            if (!empty($errores)) {
                $response['error'] = implode(', ', $errores);
            }
            
            // Enviar respuesta JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'error' => $e->getMessage()
            ];
            
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
    
    /**
     * Vista previa de imagen
     */
    public function vistaPrevia($imageId) {
        try {
            $imagen = $this->imageModel->getImageById($imageId);
            
            if (!$imagen) {
                throw new Exception('Imagen no encontrada');
            }
            
            // Incluir vista de previsualización
            include __DIR__ . '/../views/admin/propiedad/vistaPreviaImagen.php';
            
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Error al mostrar imagen: ' . $e->getMessage();
            header('Location: ' . BASE_URL . 'admin/propiedades');
            exit;
        }
    }
}
?>
