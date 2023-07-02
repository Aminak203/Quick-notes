//to create notes
function setupNoteCheckboxListeners() {
    const noteCheckboxes = document.querySelectorAll('.note-checkbox');
    const selectedNoteIds = new Set();

    noteCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', function () {
            const noteId = this.getAttribute('data-id');
            if (this.checked) {
                selectedNoteIds.add(noteId);
            } else {
                selectedNoteIds.delete(noteId);
            }
            document.getElementById('selected_note_ids').value = Array.from(selectedNoteIds).join(',');
        });
    });

    const createFolderForm = document.querySelector('.create-folder-form');
    createFolderForm.addEventListener('submit', function (e) {
        if (selectedNoteIds.size === 0) {
            e.preventDefault();
            alert('Please select at least one note before creating a folder.');
        }
    });
}

setupNoteCheckboxListeners();
