document.addEventListener("DOMContentLoaded", function () {
    const noteCheckboxes = document.querySelectorAll(".note-checkbox");
  
    noteCheckboxes.forEach((checkbox) => {
      checkbox.addEventListener("click", function (e) {
        const noteId = e.target.dataset.id;
        const selectedNoteIdsInput = document.getElementById("selected_note_ids");
        const currentSelectedNoteIds = selectedNoteIdsInput.value.split(",").filter((id) => id.length > 0);
  
        if (e.target.checked) {
          currentSelectedNoteIds.push(noteId);
        } else {
          const index = currentSelectedNoteIds.indexOf(noteId);
          if (index > -1) {
            currentSelectedNoteIds.splice(index, 1);
          }
        }
  
        selectedNoteIdsInput.value = currentSelectedNoteIds.join(",");
      });
    });
  });
  


function setupFolderButtonListeners() {
    const openFolderBtns = document.querySelectorAll('.open-folder-btn');
    openFolderBtns.forEach((btn) => {
        btn.addEventListener('click', function () {
            const folderId = this.getAttribute('data-id');
            window.location.href = `notes.php?folder_id=${folderId}`;
        });
    });

    const deleteFolderBtns = document.querySelectorAll('.delete-folder-btn');
    deleteFolderBtns.forEach((btn) => {
        btn.addEventListener('click', function () {
            const folderId = this.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this folder?')) {
                window.location.href = `delete_folder.php?folder_id=${folderId}`;
            }
        });
    });
}
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
