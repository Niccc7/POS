<?php 
require_once '../../../function.php';
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Data gagal ditambahkan'
        ]);
    }
    exit;
}

?>