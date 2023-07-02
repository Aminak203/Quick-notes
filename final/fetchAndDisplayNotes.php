<?php
include 'connection.php';

function fetchAndDisplayNotes($username, $conn, $encryption_key) {
    // Fetch the encrypted notes for the current user
    $sql = "SELECT * FROM notes WHERE UserName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $notes = [];
    while ($row = $result->fetch_assoc()) {
        // Decrypt the title and note content
        $decrypted_title = encrypt_decrypt('decrypt', $row['title'], $encryption_key);
        $decrypted_note = encrypt_decrypt('decrypt', $row['note'], $encryption_key);

        error_log("Note ID: " . $row['id']);
        error_log("Encrypted Title: " . $row['title']);
        error_log("Decrypted Title: " . $decrypted_title);
        error_log("Encrypted Note: " . $row['note']);
        error_log("Decrypted Note: " . $decrypted_note);

        $notes[] = [
            'id' => $row['id'],
            'title' => $decrypted_title,
            'note' => $decrypted_note
        ];
    }

    return $notes;
}
?>
