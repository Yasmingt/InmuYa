<?php
/**
 * Controlador de Propiedades
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja toda la funcionalidad relacionada con propiedades (pública y administrativa)
 */

class PropiedadController {
    private $propiedadModel;
    private $imageModel;
    private $favoritosModel;
    
    public function __construct() {
        // Incluir los modelos
        require_once __DIR__ . '/../models/PropiedadModel.php';
        require_once __DIR__ . '/../models/ImageModel.php';
        require_once __DIR__ . '/../models/FavoritosModel.php';
        
        $this->propiedadModel = new PropiedadModel();
        $this->imageModel = new ImageModel();
        $this->favoritosModel = new FavoritosModel();
    }
    
    /**
     * Mostrar página principal
     */
    public function index() {
        // Obtener propiedades destacadas
        $propiedadesDestacadas = $this->propiedadModel->obtenerPropiedadesDestacadas(6);
        
        // Agregar imagen principal a cada propiedad
        foreach ($propiedadesDestacadas as &$propiedad) {
            $imagenPrincipal = $this->imageModel->getMainImage($propiedad['id_propiedad']);
            if ($imagenPrincipal) {
                $propiedad['imagen_principal'] = BASE_URL . 'public/img/' . $imagenPrincipal['url_imagen'];
            } else {
                $propiedad['imagen_principal'] = BASE_URL . 'public/img/edificio.jpg';
            }
        }
        
        // Obtener estadísticas
        $stats = $this->propiedadModel->obtenerEstadisticasDePropiedades();
        
        // Incluir la vista
        include __DIR__ . '/../views/home/index.php';
    }
    
    /** Obtener propiedades destacadas */
    public function destacadas() {
        $propiedades = $this->propiedadModel->obtenerPropiedadesDestacadas(6);
        
        // Agregar imagen principal a cada propiedad
        foreach ($propiedades as &$propiedad) {
            $imagenPrincipal = $this->imageModel->getMainImage($propiedad['id_propiedad']);
            $propiedad['imagen_principal'] = $imagenPrincipal ? 
                BASE_URL . 'public/img/' . $imagenPrincipal['url_imagen'] : 
                BASE_URL . 'public/img/edificio.jpg';
        }
        
        return $propiedades;
    }
    
    /** Verificar acceso de administrador */
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
    
    /** Mostrar gestión de propiedades */
    public function adminPropiedades() {
        $pageTitle = 'Gestión de Propiedades';
        
        // Obtener filtros de la URL
        $filters = [];
        if (isset($_GET['estado'])) {
            $filters['estado'] = $_GET['estado'];
        }
        if (isset($_GET['tipo'])) {
            $filters['tipo'] = $_GET['tipo'];
        }
        if (isset($_GET['tipo_propiedad'])) {
            $filters['tipo_propiedad'] = $_GET['tipo_propiedad'];
        }
        
        // Obtener propiedades de la base de datos
        $propiedades = $this->propiedadModel->obtenerTodasLasPropiedades(20, 0, $filters);
        
        // Obtener estadísticas
        $stats = $this->propiedadModel->obtenerEstadisticasDePropiedades();
        
        // Incluir la vista de propiedades
        include __DIR__ . '/../views/admin/propiedad/propiedades.php';
    }
    
    /**
     * Crear nueva propiedad (admin)
     */
    public function crearPropiedad() {
        // Verificar sesión de administrador
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
            header('Location: ' . BASE_URL . 'index.php?route=auth/login');
            exit;
        }
        
        // Limpiar mensajes de sesión al cargar el formulario (solo GET)
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            unset($_SESSION['success_message']);
            unset($_SESSION['error_message']);
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Debug: Log que se recibió POST
            error_log("PropiedadController::crearPropiedad - POST recibido");
            error_log("POST data: " . print_r($_POST, true));
            
            try {
                $data = [
                    'titulo' => $_POST['titulo'],
                    'descripcion' => $_POST['descripcion'],
                    'tipo' => $_POST['tipo'],
                    'precio' => $_POST['precio'],
                    'area' => $_POST['area'],
                    'habitaciones' => $_POST['habitaciones'],
                    'banos' => $_POST['banos'],
                    'parqueadero' => isset($_POST['parqueadero']) ? 1 : 0,
                    'direccion' => $_POST['direccion'],
                    'id_ciudad' => !empty($_POST['id_ciudad']) ? $_POST['id_ciudad'] : null,
                    'id_barrio' => !empty($_POST['id_barrio']) ? $_POST['id_barrio'] : null,
                    'id_usuario' => $_SESSION['user_id'],
                    'estado' => $_POST['estado'] ?? 'disponible',
                    'tipo_propiedad' => $_POST['tipo_propiedad'],
                    'destacado' => isset($_POST['destacado']) ? 1 : 0,
                    'piso' => $_POST['piso'] ?? null,
                    'ascensor' => isset($_POST['ascensor']) ? 1 : 0,
                    'balcon' => isset($_POST['balcon']) ? 1 : 0,
                    'terraza' => isset($_POST['terraza']) ? 1 : 0,
                    'jardin' => isset($_POST['jardin']) ? 1 : 0,
                    'piscina' => isset($_POST['piscina']) ? 1 : 0,
                    'gimnasio' => isset($_POST['gimnasio']) ? 1 : 0,
                    'seguridad_24h' => isset($_POST['seguridad_24h']) ? 1 : 0,
                    'mascotas_permitidas' => isset($_POST['mascotas_permitidas']) ? 1 : 0,
                    'precio_negociable' => isset($_POST['precio_negociable']) ? 1 : 0,
                    'incluye_administracion' => isset($_POST['incluye_administracion']) ? 1 : 0,
                    'valor_administracion' => $_POST['valor_administracion'] ?? null,
                    'incluye_servicios' => isset($_POST['incluye_servicios']) ? 1 : 0,
                    'telefono_contacto' => $_POST['telefono_contacto'] ?? null,
                    'email_contacto' => $_POST['email_contacto'] ?? null,
                    'nombre_contacto' => $_POST['nombre_contacto'] ?? null,
                    'mostrar_telefono' => isset($_POST['mostrar_telefono']) ? 1 : 0,
                    'mostrar_email' => isset($_POST['mostrar_email']) ? 1 : 0
                ];
                
                // Debug: Log datos preparados
                error_log("PropiedadController::crearPropiedad - Datos preparados: " . print_r($data, true));
                
                $propertyId = $this->propiedadModel->crearNuevaPropiedad($data);
                
                // Debug: Log éxito
                error_log("PropiedadController::crearPropiedad - Propiedad creada con ID: " . $propertyId);
                
                // Procesar imágenes si se subieron
                if (isset($_FILES['imagenes']) && !empty($_FILES['imagenes']['name'][0])) {
                    error_log("PropiedadController::crearPropiedad - Procesando " . count($_FILES['imagenes']['name']) . " imágenes");
                    
                    try {
                        $imageResult = $this->imageModel->uploadImages($propertyId, $_FILES['imagenes']);
                        
                        error_log("PropiedadController::crearPropiedad - Resultado de imágenes: " . print_r($imageResult, true));
                        
                        if ($imageResult['success']) {
                            error_log("PropiedadController::crearPropiedad - Imágenes subidas exitosamente: " . count($imageResult['uploaded_images']));
                            
                            // Si hay errores en algunas imágenes, agregar al mensaje
                            if (!empty($imageResult['errors'])) {
                                $_SESSION['success_message'] = 'Propiedad creada exitosamente con ' . count($imageResult['uploaded_images']) . ' imagen(es). Algunas imágenes no se pudieron subir: ' . implode(', ', $imageResult['errors']);
                            } else {
                                $_SESSION['success_message'] = 'Propiedad creada exitosamente con ' . count($imageResult['uploaded_images']) . ' imagen(es)';
                            }
                        } else {
                            error_log("PropiedadController::crearPropiedad - Error en subida de imágenes: " . implode(', ', $imageResult['errors']));
                            $_SESSION['success_message'] = 'Propiedad creada exitosamente, pero hubo problemas con las imágenes: ' . implode(', ', $imageResult['errors']);
                        }
                    } catch (Exception $e) {
                        error_log("PropiedadController::crearPropiedad - Excepción al subir imágenes: " . $e->getMessage());
                        error_log("PropiedadController::crearPropiedad - Stack trace: " . $e->getTraceAsString());
                        $_SESSION['success_message'] = 'Propiedad creada exitosamente, pero hubo problemas con las imágenes: ' . $e->getMessage();
                    }
                } else {
                    error_log("PropiedadController::crearPropiedad - No se subieron imágenes");
                    $_SESSION['success_message'] = 'Propiedad creada exitosamente';
                }
                
                // Verificar si es una petición AJAX
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => true,
                        'message' => $_SESSION['success_message'],
                        'property_id' => $propertyId
                    ]);
                    exit;
                }
                
                // Redirección normal (no AJAX)
                header('Location: ' . BASE_URL . 'index.php?route=admin/propiedades');
                exit;
                
            } catch (Exception $e) {
                // Debug: Log error
                error_log("PropiedadController::crearPropiedad - Error: " . $e->getMessage());
                error_log("PropiedadController::crearPropiedad - Stack trace: " . $e->getTraceAsString());
                
                $_SESSION['error_message'] = 'Error al crear la propiedad: ' . $e->getMessage();
                
                // Verificar si es una petición AJAX
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => false,
                        'message' => $_SESSION['error_message']
                    ]);
                    exit;
                }
            }
        }
        
        // Obtener ciudades para el formulario
        $ciudades = $this->propiedadModel->obtenerCiudades();
        
        // Mostrar formulario de creación
        include __DIR__ . '/../views/admin/propiedad/crearPropiedad.php';
    }
    
    /**Editar propiedad (admin)*/
    public function editarPropiedad() {        
        error_log("PropiedadController::editarPropiedad - Método iniciado");
        
        $id = $_GET['id'] ?? null;
        
        if (!$id || !is_numeric($id)) {
            $_SESSION['error_message'] = 'ID de propiedad inválido';
            header('Location: ' . BASE_URL . 'index.php?route=admin/propiedades');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Debug: Log que se recibió POST
            error_log("PropiedadController::editarPropiedad - POST recibido");
            error_log("POST data: " . print_r($_POST, true));
            error_log("FILES data: " . print_r($_FILES, true));
            error_log("Estado recibido: " . ($_POST['estado'] ?? 'NO DEFINIDO'));
            
            // Debug específico para datos de contacto
            error_log("Datos de contacto recibidos:");
            error_log("nombre_contacto: " . ($_POST['nombre_contacto'] ?? 'NO DEFINIDO'));
            error_log("telefono_contacto: " . ($_POST['telefono_contacto'] ?? 'NO DEFINIDO'));
            error_log("email_contacto: " . ($_POST['email_contacto'] ?? 'NO DEFINIDO'));
            error_log("mostrar_telefono: " . (isset($_POST['mostrar_telefono']) ? 'SÍ' : 'NO'));
            error_log("mostrar_email: " . (isset($_POST['mostrar_email']) ? 'SÍ' : 'NO'));
            
            try {
                $data = [
                    'titulo' => $_POST['titulo'],
                    'descripcion' => $_POST['descripcion'],
                    'tipo' => $_POST['tipo'],
                    'precio' => $_POST['precio'],
                    'area' => $_POST['area'],
                    'habitaciones' => $_POST['habitaciones'],
                    'banos' => $_POST['banos'],
                    'parqueadero' => isset($_POST['parqueadero']) ? 1 : 0,
                    'direccion' => $_POST['direccion'],
                    'id_ciudad' => !empty($_POST['id_ciudad']) ? $_POST['id_ciudad'] : null,
                    'id_barrio' => !empty($_POST['id_barrio']) ? $_POST['id_barrio'] : null,
                    'estado' => $_POST['estado'],
                    'tipo_propiedad' => $_POST['tipo_propiedad'],
                    'destacado' => isset($_POST['destacado']) ? 1 : 0,
                    'piso' => $_POST['piso'] ?? null,
                    'ascensor' => isset($_POST['ascensor']) ? 1 : 0,
                    'balcon' => isset($_POST['balcon']) ? 1 : 0,
                    'terraza' => isset($_POST['terraza']) ? 1 : 0,
                    'jardin' => isset($_POST['jardin']) ? 1 : 0,
                    'piscina' => isset($_POST['piscina']) ? 1 : 0,
                    'gimnasio' => isset($_POST['gimnasio']) ? 1 : 0,
                    'seguridad_24h' => isset($_POST['seguridad_24h']) ? 1 : 0,
                    'mascotas_permitidas' => isset($_POST['mascotas_permitidas']) ? 1 : 0,
                    'precio_negociable' => isset($_POST['precio_negociable']) ? 1 : 0,
                    'incluye_administracion' => isset($_POST['incluye_administracion']) ? 1 : 0,
                    'valor_administracion' => $_POST['valor_administracion'] ?? null,
                    'incluye_servicios' => isset($_POST['incluye_servicios']) ? 1 : 0,
                    'telefono_contacto' => $_POST['telefono_contacto'] ?? null,
                    'email_contacto' => $_POST['email_contacto'] ?? null,
                    'nombre_contacto' => $_POST['nombre_contacto'] ?? null,
                    'mostrar_telefono' => isset($_POST['mostrar_telefono']) ? 1 : 0,
                    'mostrar_email' => isset($_POST['mostrar_email']) ? 1 : 0
                ];
                
                // Debug: Log datos preparados
                error_log("PropiedadController::editarPropiedad - Datos preparados: " . print_r($data, true));
                error_log("PropiedadController::editarPropiedad - Estado en datos: " . ($data['estado'] ?? 'NO DEFINIDO'));
                
                $updateResult = $this->propiedadModel->actualizarPropiedad($id, $data);
                
                // Debug: Log resultado de actualización
                error_log("PropiedadController::editarPropiedad - Resultado actualización: " . ($updateResult ? 'true' : 'false'));
                
                // Procesar imágenes si se subieron
                if (isset($_FILES['imagenes']) && !empty($_FILES['imagenes']['name'][0])) {
                    error_log("PropiedadController::editarPropiedad - Procesando imágenes nuevas");
                    error_log("PropiedadController::editarPropiedad - Número de archivos: " . count($_FILES['imagenes']['name']));
                    
                    try {
                        $imageResult = $this->imageModel->uploadImages($id, $_FILES['imagenes']);
                        
                        if ($imageResult['success']) {
                            error_log("PropiedadController::editarPropiedad - Imágenes subidas: " . count($imageResult['uploaded_images']));
                            
                            // Si hay errores en algunas imágenes, agregar al mensaje
                            if (!empty($imageResult['errors'])) {
                                $_SESSION['success_message'] = 'Propiedad actualizada exitosamente. Algunas imágenes no se pudieron subir: ' . implode(', ', $imageResult['errors']);
                            } else {
                                $_SESSION['success_message'] = 'Propiedad actualizada exitosamente con ' . count($imageResult['uploaded_images']) . ' imagen(es) adicional(es)';
                            }
                        } else {
                            error_log("PropiedadController::editarPropiedad - Error al subir imágenes: " . implode(', ', $imageResult['errors']));
                            $_SESSION['success_message'] = 'Propiedad actualizada exitosamente, pero hubo problemas con las imágenes: ' . implode(', ', $imageResult['errors']);
                        }
                    } catch (Exception $e) {
                        error_log("PropiedadController::editarPropiedad - Error al subir imágenes: " . $e->getMessage());
                        $_SESSION['success_message'] = 'Propiedad actualizada exitosamente, pero hubo problemas con las imágenes: ' . $e->getMessage();
                    }
                } else {
                    error_log("PropiedadController::editarPropiedad - No se subieron imágenes nuevas");
                    $_SESSION['success_message'] = 'Propiedad actualizada exitosamente';
                }
                
                // Verificar si es una petición AJAX
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => true,
                        'message' => $_SESSION['success_message']
                    ]);
                    exit;
                }
                
                header('Location: ' . BASE_URL . 'index.php?route=admin/propiedades');
                exit;
                
            } catch (Exception $e) {
                error_log("PropiedadController::editarPropiedad - Error principal: " . $e->getMessage());
                error_log("PropiedadController::editarPropiedad - Stack trace: " . $e->getTraceAsString());
                $_SESSION['error_message'] = 'Error al actualizar la propiedad: ' . $e->getMessage();
                
                // Verificar si es una petición AJAX
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => false,
                        'message' => $_SESSION['error_message']
                    ]);
                    exit;
                }
            }
        }
        
        // Obtener datos de la propiedad
        $propiedad = $this->propiedadModel->obtenerPropiedadPorId($id);
        
        if (!$propiedad) {
            $_SESSION['error_message'] = 'Propiedad no encontrada';
            header('Location: ' . BASE_URL . 'index.php?route=admin/propiedades');
            exit;
        }
        
        // Obtener ciudades para el formulario
        $ciudades = $this->propiedadModel->obtenerCiudades();
        
        // Obtener imágenes de la propiedad
        $imagenes = $this->imageModel->getImagesByProperty($id);
        error_log("PropiedadController::editarPropiedad - Imágenes encontradas: " . count($imagenes));
        
        include __DIR__ . '/../views/admin/propiedad/editarPropiedad.php';
    }
    
    /** Eliminar propiedad */
    public function eliminarPropiedad() {        
        // Verificar sesión
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $id = $_POST['property_id'] ?? $_GET['id'] ?? null;
        
        if (!$id || !is_numeric($id)) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'ID de propiedad inválido']);
                exit;
            } else {
                $_SESSION['error_message'] = 'ID de propiedad inválido';
                header('Location: ' . BASE_URL . 'index.php?route=admin/propiedades');
                exit;
            }
        }
        
        try {
            $this->propiedadModel->eliminarPropiedad($id);
            
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Propiedad eliminada exitosamente']);
                exit;
            } else {
                $_SESSION['success_message'] = 'Propiedad eliminada exitosamente';
                header('Location: ' . BASE_URL . 'index.php?route=admin/propiedades');
                exit;
            }
        } catch (Exception $e) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Error al eliminar la propiedad: ' . $e->getMessage()]);
                exit;
            } else {
                $_SESSION['error_message'] = 'Error al eliminar la propiedad: ' . $e->getMessage();
                header('Location: ' . BASE_URL . 'index.php?route=admin/propiedades');
                exit;
            }
        }
    }
    
    /** Toggle destacado */
    public function toggleDestacado() {        
        try {
            // Verificar que sea una petición AJAX
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                
                error_log("AJAX request detected");
                
                // Leer el JSON del cuerpo de la petición
                $input = json_decode(file_get_contents('php://input'), true);
                $destacado = $input['destacado'] ?? 0;
                $id = $input['id_propiedad'] ?? null;
                
                error_log("Destacado value: " . $destacado . ", ID: " . $id);
                
                if (!$id || !is_numeric($id)) {
                    throw new Exception("ID de propiedad inválido");
                }
                
                $this->propiedadModel->toggleDestacado($id, $destacado);
                
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
                exit;
            } else {
                // Petición normal (no AJAX) - obtener ID de GET
                $id = $_GET['id'] ?? null;
                if (!$id || !is_numeric($id)) {
                    throw new Exception("ID de propiedad inválido");
                }
                
                $this->propiedadModel->toggleDestacado($id);
                $_SESSION['success_message'] = 'Estado destacado actualizado';
                header('Location: ' . BASE_URL . 'index.php?route=admin/propiedades');
                exit;
            }
        } catch (Exception $e) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
                exit;
            } else {
                $_SESSION['error_message'] = 'Error al actualizar el estado destacado: ' . $e->getMessage();
                header('Location: ' . BASE_URL . 'index.php?route=admin/propiedades');
                exit;
            }
        }
    }
    
    /**
     * Obtener barrios por ciudad (AJAX)
     */
    public function obtenerBarriosPorCiudad() {
        $id_ciudad = $_GET['id_ciudad'] ?? null;
        
        if (!$id_ciudad || !is_numeric($id_ciudad)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'ID de ciudad inválido']);
            exit;
        }
        
        try {
            $barrios = $this->propiedadModel->obtenerBarriosPorCiudad($id_ciudad);
            
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'barrios' => $barrios]);
            exit;
            
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit;
        }
    }
}
?>
