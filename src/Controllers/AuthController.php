<?php

namespace App\Controllers;

use App\Core\Database;

class AuthController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function showLogin() {
        session_start();
        if (isset($_SESSION['id'])) {
            header('Location: /index');
            exit();
        }
        require __DIR__.'/../Views/login.php';
    }

    public function showRegister() {
        session_start();
        if (isset($_SESSION['id'])) {
            header('Location: /index');
            exit();
        }
        require __DIR__.'/../Views/register.php';
    }

    public function showIndex() {
        require __DIR__.'/../Views/index.php';
    }

    public function showFavorites() {
        require __DIR__.'/../Views/favorites.php';
    }

    public function showCatalog() {
        require __DIR__.'/../Views/catalogo.php';
    }

    public function showBook() {
        require __DIR__.'/../Views/book_details.php';
    }

    public function showConfirmBook() {
        require __DIR__.'/../Views/confirm_loan.php';
    }

    public function showLoans() {
        require __DIR__.'/../Views/loans.php';
    }

    public function showLoansUsers() {
        require __DIR__.'/../Views/loansUsers.php';
    }

    public function showAccountDetails() {
        require __DIR__.'/../Views/accountDetails.php';
    }

    public function showChangePassword() {
        require __DIR__.'/../Views/changePassword.php';
    }

    public function showQuienesSomos() {
        require __DIR__.'/../Views/quienes_somos.php';
    }


    public function showEditUser() {
        /*session_start();
        if (!isset($_SESSION['id'])) {
            header('Location: /login');
            exit();
        }*/
        
        $user_id = $_GET['id'] ?? 0;
        if (!$user_id) {
            echo 'ID de usuario no proporcionado';
            return;
        }
        
        try {
            $connection = $this->db->getConnection();
            $query = $connection->prepare("SELECT * FROM USERS WHERE ID_USER = ?");
            $query->bind_param('i', $user_id);
            $query->execute();
            $result = $query->get_result();
            $user = $result->fetch_assoc();
            
            if ($user) {
                require __DIR__.'/../Views/edit_user.php';
            } else {
                echo 'Usuario no encontrado';
            }
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    

    public function showListUser() {
        require __DIR__.'/../Views/list_user.php'; // Muestra el formulario de edición
    }

    public function addFavorite() {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location: /login');
            exit();
        }
    
        $book_id = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;
        $user_id = $_SESSION['id'];
    
        $connection = $this->db->getConnection();
    
        // Verificar si el libro existe en la tabla BOOK
        $query = $connection->prepare("SELECT ID_BOOK FROM book WHERE ID_BOOK = ?");
        $query->bind_param('i', $book_id);
        $query->execute();
        $bookExists = $query->get_result()->num_rows > 0;
    
        if (!$bookExists) {
            echo 'El libro no existe en la base de datos.';
            return;
        }
    
        // Insertar en FAVORITES
        $query = $connection->prepare("INSERT INTO FAVORITES (ID_USER, ID_BOOK) VALUES (?, ?)");
        $query->bind_param('ii', $user_id, $book_id);
    
        if ($query->execute()) {
            header('Location: /bookDetails?id=' . $book_id);
            exit();
        } else {
            echo 'Error al agregar a favoritos';
        }
    }

    public function removeFavorite() {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location: /login');
            exit();
        }

        $book_id = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;
        $user_id = $_SESSION['id'];

        $connection = $this->db->getConnection();
        $query = $connection->prepare("DELETE FROM FAVORITES WHERE ID_USER = ? AND ID_BOOK = ?");
        $query->bind_param('ii', $user_id, $book_id);

        if ($query->execute()) {
            header('Location: /bookDetails?id=' . $book_id);
            exit();
        } else {
            echo 'Error al eliminar de favoritos';
        }
    }

    public function sendRegister() {
        $nombre = $_POST['nombre'] ?? '';
        $apellido = $_POST['apellido'] ?? '';
        $correo = $_POST['correo'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $direccion = $_POST['direccion'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!$nombre || !$apellido || !$correo || !$password) {
            echo 'Todos los campos son obligatorios';
            return;
        }

        $passwordEncrypted = password_hash($password, PASSWORD_DEFAULT);

        try {
            $connection = $this->db->getConnection();
            $query = $connection->prepare("INSERT INTO USERS (FIRST_NAME, LAST_NAME, EMAIL, PHONE, ADDRESS, PASSWORD) VALUES (?, ?, ?, ?, ?, ?)");
            $query->bind_param('ssssss', $nombre, $apellido, $correo, $telefono, $direccion, $passwordEncrypted);

            if ($query->execute()) {
                header('Location: /login'); // Redirige a la página de login
                exit();
            } else {
                echo 'No se pudo generar el registro';
            }
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $redirect = $_POST['redirect'] ?? '/index'; // URL de redirección predeterminada
    
        if (!$email || !$password) {
            header('Location: /login?error=' . urlencode('Todos los campos son obligatorios'));
            exit();
        }
    
        try {
            $connection = $this->db->getConnection();
            $query = $connection->prepare('SELECT * FROM USERS WHERE EMAIL = ?');
            $query->bind_param('s', $email);
            $query->execute();
    
            $result = $query->get_result();
    
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                $userPasswordEncrypted = $user['PASSWORD'];
                $verifyPassword = password_verify($password, $userPasswordEncrypted);
    
                if ($verifyPassword) {
                    session_start();
                    $_SESSION['id'] = $user["ID_USER"];
                    $_SESSION['name'] = $user['FIRST_NAME'];
                    $_SESSION['email'] = $user["EMAIL"];
                    
                    header('Location: ' . htmlspecialchars($redirect, ENT_QUOTES, 'UTF-8'));
                    exit();
                } else {
                    header('Location: /login?error=' . urlencode('Contraseña incorrecta'));
                    exit();
                }
            } else {
                header('Location: /login?error=' . urlencode('Usuario no registrado, ¡Registrate ahora!'));
                exit();
            }
        } catch (\Exception $e) {
            header('Location: /login?error=' . urlencode('Error: ' . $e->getMessage()));
            exit();
        }
    }
    
    

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /index"); // Redirige a la página de inicio después de cerrar sesión
        exit();
    }

    public function requestLoan() {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location: /login');
            exit();
        }
    
        $user_id = $_SESSION['id'];
        $book_id = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;
    
        try {
            $connection = $this->db->getConnection();
    
            // Verificar el stock del libro
            $sql = "SELECT STOCK FROM book WHERE ID_BOOK = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param('i', $book_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $book = $result->fetch_assoc();
    
            if ($book && $book['STOCK'] > 0) {
                // Iniciar la transacción
                $connection->begin_transaction();
    
                // Insertar nueva solicitud de préstamo
                //$sql = "INSERT INTO loans (ID_USER, ID_BOOK, LOAN_DATE) VALUES (?, ?, NOW())";
                //$stmt = $connection->prepare($sql);
    
                if ($stmt->execute()) {
                    // Actualizar el stock del libro
                    $sql = "UPDATE book SET STOCK = STOCK - 1 WHERE ID_BOOK = ?";
                    $stmt = $connection->prepare($sql);
                    $stmt->bind_param('i', $book_id);
    
                    if ($stmt->execute()) {
                        // Confirmar la transacción
                        $connection->commit();
                        header("Location: /bookDetails?id=" . $book_id);
                    } else {
                        // Revertir la transacción
                        $connection->rollback();
                        echo "Error al actualizar el stock del libro.";
                    }
                } else {
                    // Revertir la transacción
                    $connection->rollback();
                    echo "Error al solicitar el préstamo.";
                }
    
                $stmt->close();
            } else {
                echo "No hay suficiente stock del libro.";
            }

        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function updateUser() {
        $user_id = $_POST['user_id'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $apellido = $_POST['apellido'] ?? '';
        $correo = $_POST['correo'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $direccion = $_POST['direccion'] ?? '';
        $password = $_POST['password'] ?? '';
    
        if (!$user_id || !$nombre || !$apellido || !$correo || !$telefono || !$direccion) {
            echo 'Todos los campos son obligatorios';
            return;
        }
    
        $passwordQuery = '';
        if ($password) {
            $passwordEncrypted = password_hash($password, PASSWORD_DEFAULT);
            $passwordQuery = ", PASSWORD = ?";
        }
    
        try {
            $connection = $this->db->getConnection();
            $queryString = "UPDATE USERS SET FIRST_NAME = ?, LAST_NAME = ?, EMAIL = ?, PHONE = ?, ADDRESS = ?" . $passwordQuery . " WHERE ID_USER = ?";
            $query = $connection->prepare($queryString);
    
            if ($password) {
                $query->bind_param('ssssssi', $nombre, $apellido, $correo, $telefono, $direccion, $passwordEncrypted, $user_id);
            } else {
                $query->bind_param('sssssi', $nombre, $apellido, $correo, $telefono, $direccion, $user_id);
            }
    
            if ($query->execute()) {
                header('Location: /listUsers'); // Redirige a la lista de usuarios después de actualizar
                exit();
            } else {
                echo 'Error al actualizar el perfil';
            }
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }   
    

    public function deleteUser() {
        $user_id = $_POST['user_id'] ?? 0;
    
        if (!$user_id) {
            echo 'ID de usuario no proporcionado';
            return;
        }
    
        try {
            $connection = $this->db->getConnection();
            $query = $connection->prepare("DELETE FROM USERS WHERE ID_USER = ?");
            $query->bind_param('i', $user_id);
    
            if ($query->execute()) {
                header('Location: /listUsers'); // Redirige a la lista de usuarios después de actualizar
                exit();
            } else {
                echo 'Error al eliminar el usuario';
            }
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    
    public function listUsers() {
        try {
            $connection = $this->db->getConnection();
            $query = $connection->prepare("SELECT ID_USER, FIRST_NAME, LAST_NAME, EMAIL, PHONE, ADDRESS FROM USERS");
            $query->execute();
            $result = $query->get_result();
            $users = $result->fetch_all(MYSQLI_ASSOC);
    
            require __DIR__.'/../Views/user_list.php'; // Muestra la lista de usuarios
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    
    public function process_loan() {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location: /login');
            exit();
        }
    
        $user_id = $_SESSION['id'];
        $book_id = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;
        $return_date = isset($_POST['return_date']) ? $_POST['return_date'] : '';
    
        if (empty($book_id) || empty($return_date)) {
            echo "Todos los campos son obligatorios.";
            return;
        }
    
        try {
            $connection = $this->db->getConnection();
            $connection->begin_transaction();
    
            // Verificar el stock del libro
            $sql = "SELECT STOCK FROM book WHERE ID_BOOK = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param('i', $book_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $book = $result->fetch_assoc();
    
            if ($book && $book['STOCK'] > 0) {
                // Insertar el préstamo en la base de datos
                $sql = "INSERT INTO loans (ID_USER, ID_BOOK, LOAN_DATE, RETURN_DATE) VALUES (?, ?, NOW(), ?)";
                $stmt = $connection->prepare($sql);
                $stmt->bind_param('iis', $user_id, $book_id, $return_date);
    
                if ($stmt->execute()) {
                    // Actualizar el stock del libro
                    $sql = "UPDATE book SET STOCK = STOCK - 1 WHERE ID_BOOK = ?";
                    $stmt = $connection->prepare($sql);
                    $stmt->bind_param('i', $book_id);
    
                    if ($stmt->execute()) {
                        // Confirmar la transacción
                        $connection->commit();
                        header("Location: /bookDetails?id=" . $book_id);
                        exit();
                    } else {
                        // Revertir la transacción
                        $connection->rollback();
                        echo "Error al actualizar el stock del libro.";
                    }
                } else {
                    // Revertir la transacción
                    $connection->rollback();
                    echo "Error al procesar el préstamo.";
                }
            } else {
                echo "No hay suficiente stock del libro.";
            }
    
            $stmt->close();
            $connection->close();
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    
    
    public function deleteLoan() {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location: /login');
            exit();
        }
    
        // Obtener el ID del préstamo desde la solicitud POST
        $loan_id = $_POST['loan_id'] ?? null;
    
        // Depura el valor del loan_id
        if ($loan_id === null) {
            echo 'ID de préstamo no proporcionado';
            return;
        }
    
        echo 'Loan ID recibido: ' . htmlspecialchars($loan_id);
    
        try {
            $connection = $this->db->getConnection();
    
            // Iniciar la transacción
            $connection->begin_transaction();
    
            // Obtener el ID del libro asociado al préstamo
            $sql = "SELECT ID_BOOK FROM loans WHERE ID_LOAN = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param('i', $loan_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $loan = $result->fetch_assoc();
    
            if ($loan) {
                $book_id = $loan['ID_BOOK'];
    
                // Borrar el préstamo
                $sql = "DELETE FROM loans WHERE ID_LOAN = ?";
                $stmt = $connection->prepare($sql);
                $stmt->bind_param('i', $loan_id);
    
                if ($stmt->execute()) {
                    // Actualizar el stock del libro
                    $sql = "UPDATE book SET STOCK = STOCK + 1 WHERE ID_BOOK = ?";
                    $stmt = $connection->prepare($sql);
                    $stmt->bind_param('i', $book_id);
    
                    if ($stmt->execute()) {
                        // Confirmar la transacción
                        $connection->commit();
                        header('Location: /loansUsers'); // Redirige a la lista de préstamos
                        exit();
                    } else {
                        // Revertir la transacción
                        $connection->rollback();
                        echo "Error al actualizar el stock del libro.";
                    }
                } else {
                    // Revertir la transacción
                    $connection->rollback();
                    echo "Error al eliminar el préstamo.";
                }
    
                $stmt->close();
            } else {
                echo "Préstamo no encontrado.";
            }
    
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    

    public function changePassword() {
    session_start();
    if (!isset($_SESSION['id'])) {
        header('Location: /login');
        exit();
    }

    // Verificar si se ha enviado el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($newPassword !== $confirmPassword) {
            echo 'Las nuevas contraseñas no coinciden.';
            return;
        }

        $userId = $_SESSION['id'];
        $connection = $this->db->getConnection();

        // Verificar la contraseña actual
        $sql = "SELECT password FROM users WHERE ID_USER = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($currentPassword, $user['password'])) {
            // Actualizar la contraseña
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password = ? WHERE ID_USER = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param('si', $hashedPassword, $userId);

            if ($stmt->execute()) {
                // Redirigir al index después de actualizar la contraseña
                header('Location: /index');
                exit();
            } else {
                echo 'Error al actualizar la contraseña.';
            }
        } else {
            echo 'Contraseña actual incorrecta.';
        }

        $stmt->close();
    }
}

}
