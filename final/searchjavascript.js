fetch("start_session.php")
  .then(response => response.text())
  .then(result => console.log(result))
  .catch(error => console.error(error));
  const userName = document.getElementById('hidden-username').value;
  function removeOptions() {
    const options = document.querySelectorAll('.option');
    options.forEach(option => option.remove());
  }

  document.addEventListener('click', removeOptions);

  
  document.getElementById('notes-link').addEventListener('click', function() {
    document.addEventListener('click', removeOptions);

    let mainContent = document.querySelector('.main-content');
    mainContent.innerHTML = `
        <h2>Notetaking App</h2>
        <form method="post" action="main.php">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title">

            <label for="note">Note:</label>
            <textarea id="note" name="note"></textarea>
            <script>
                CKEDITOR.replace('note');
            </script>

            <input type="submit" value="Save Note" name="submit">
        </form>`;
});

function getNoteContent(noteId) {
    if (typeof noteId === 'undefined') {
        conso
        le.error('Invalid note ID:', noteId);
        return;
    }

    console.log('Fetching note content for note ID:', noteId);
    fetch(`get_note.php?note_id=${noteId}&UserName=${encodeURIComponent(userName)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error ${response.status}`);
            }
            return response.text();
        })
        .then(data => {
            CKEDITOR.instances['note'].setData(data);
        })
        .catch(error => {
            console.error('Error fetching note content:', error);
        });
}



function setupButtonListeners() {
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', (e) => {
            const noteId = e.target.dataset.id;
            // Edit the note with the given noteId
        });
    });

    // Get the edit buttons
    document.querySelectorAll('.edit-btn').forEach(button => {
        
        button.addEventListener('click', (e) => {
            // Close previous modal or form if it exists
            const existingForm = document.querySelector('.edit-note-form');
            if (existingForm) {
                existingForm.remove();
            }
            // Create new form
            const noteId = e.target.dataset.id;
            $UserName = userName;

            fetch(`get_note.php?note_id=${noteId}&UserName=${encodeURIComponent(window.userName)}`)


                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`HTTP error ${response.status}`);
                    }
                    return response.text();
                })
                .then((noteContent) => {
                    const editNoteForm = document.createElement('form');
                    editNoteForm.classList.add('edit-note-form');
                    editNoteForm.innerHTML = `
                        <input type="hidden" name="note_id" value="${noteId}">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" value="${e.target.parentElement.querySelector('h4').innerText}">
                        <label for="note">Note:</label>
                        <textarea id="note" name="note">${e.target.parentElement.querySelector('p').innerHTML}</textarea>

                        <input type="submit" value="Update Note" name="submit">
                    `;
                    e.target.parentElement.appendChild(editNoteForm);
                    editNoteForm.addEventListener('submit', (e) => {
                        e.preventDefault();
                        const formData = new FormData(e.target);
                        console.log("Fetch URL:", 'update_note.php');
fetch('update_note.php', {
    method: 'POST',
    body: formData
})
.then((response) => {
    if (!response.ok) {
        throw new Error(`HTTP error ${response.status}`);
    }
    return response.text();
})
.then((result) => {
    console.log(result);
    alert(result);
    // Reload the page to display the updated note list
    window.location.reload();
})
.catch((error) => {
    console.error('Error updating note:', error);
    alert('Error updating note:', error);
});

console.log('formData:', Array.from(formData.entries())); // Add this line
        });
                })
                .catch((error) => {
                   
                    console.error('Error fetching note content:', error);
                    alert('Error fetching note content:', error);
                    });
                    });
                    });
                    document.querySelectorAll('.delete-btn').forEach(button => {
                        button.addEventListener('click', (e) => {
                            const noteId = parseInt(e.target.dataset.id);
                            if (isNaN(noteId)) {
                                console.error('Invalid note ID');
                                return;
                            }
                            fetch('delete_note.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: `note_id=${noteId}`,
                            })
                            .then((response) => {
                                if (!response.ok) {
                                    throw new Error(`HTTP error ${response.status}`);
                                }
                                return response.text();
                            })
                            .then((result) => {
                                if (result.trim() === 'Note deleted successfully') {
                                    const liElement = e.target.parentElement;
                                    if (liElement.parentElement !== null) {
                                        liElement.remove();
                                    }
                                    console.log(result);
                                    alert(result);
                                } else {
                                    console.error(result);
                                    alert(result);
                                }
                            })
                            .catch((error) => {
                                console.error('Error deleting the note:', error);
                                alert('Error deleting the note:', error);
                            });
                        });
                    });
                    
                    document.querySelectorAll('.save-btn').forEach(button => {
                        button.addEventListener('click', (e) => {
                            const noteId = e.target.dataset.id;
                            // Save the note with the given noteId to the local device
                            const noteTitle = e.target.parentElement.querySelector('h4').innerText;
                            const noteText = e.target.parentElement.querySelector('p').innerText;
                    
                            let mediaType = null;
                            let mediaUrl = null;
                    
                            const mediaElement = e.target.parentElement.querySelector('img, video');
                            if (mediaElement) {
                                mediaType = mediaElement.tagName.toLowerCase();
                                mediaUrl = mediaElement.src;
                            }
                    
                            let blob = null;
                            let downloadLink = null;
                    
                            if (mediaType === 'img') {
                                fetch(mediaUrl)
                                    .then(response => response.blob())
                                    .then(data => {
                                        blob = new Blob([data], { type: 'image/jpeg' });
                                        downloadLink = createDownloadLink(blob, `${noteTitle}.jpg`);
                                        downloadLink.click();
                                    });
                            } else if (mediaType === 'video') {
                                fetch(mediaUrl)
                                    .then(response => response.blob())
                                    .then(data => {
                                        blob = new Blob([data], { type: 'video/mp4' });
                                        downloadLink = createDownloadLink(blob, `${noteTitle}.mp4`);
                                        downloadLink.click();
                                    });
                            } else {
                                blob = new Blob([noteText], { type: 'text/plain;charset=utf-8' });
                                downloadLink = createDownloadLink(blob, `${noteTitle}.txt`);
                                downloadLink.click();
                            }
                        });
                    });
                    
                    function createDownloadLink(blob, filename) {
                        const downloadUrl = URL.createObjectURL(blob);
                        const downloadLink = document.createElement('a');
                        downloadLink.href = downloadUrl;
                        downloadLink.download = filename;
                        document.body.appendChild(downloadLink);
                        return downloadLink;
                    }
                    
                    
                    
                    document.querySelectorAll('.share-btn').forEach(button => {
                        button.addEventListener('click', (e) => {
                            const noteId = e.target.dataset.id;
                            // Share the note with the given noteId
                            // You can use the Web Share API for sharing content
                            // Reference: https://developer.mozilla.org/en-US/docs/Web/API/Navigator/share
                    
                            if (navigator.share) {
                                const noteTitle = e.target.parentElement.querySelector('h4').innerText;
                                const noteText = e.target.parentElement.querySelector('p').innerText;
                                const shareData = {
                                    title: noteTitle,
                                    text: noteText,
                                    url: window.location.href,
                                };
                    
                                navigator.share(shareData)
                                    .then(() => console.log('Successful share'))
                                    .catch((error) => console.log('Error sharing:', error));
                            } else {
                                console.log('Web Share API not supported');
                            }
                        });
                    });
                }
                window.onload = function() {
                    setupButtonListeners();
                
                    const fetchNoteContent = (noteId, retryCount = 5) => {
                        const username = $_SESSION['UserName'];
                        const url = noteId ? `get_note.php?note_id=${noteId}` : `get_note.php?username=${encodeURIComponent(username)}`;
                
                        fetch(url)
                            .then((response) => {
                                if (!response.ok) {
                                    throw new Error(`HTTP error ${response.status}`);
                                }
                                return response.text();
                            })
                            .then((noteContent) => {
                                const noteTextArea = document.querySelector('#note');
                                CKEDITOR.instances['note'].setData(noteContent);
                            })
                            .catch((error) => {
                                console.error('Error fetching note content:', error);
                                if (retryCount > 0) {
                                    setTimeout(() => {
                                        fetchNoteContent(noteId, retryCount - 1);
                                    }, 1000);
                                } else {
                                    alert('Failed to fetch note content after several attempts.');
                                }
                            });
                    };
                }
                