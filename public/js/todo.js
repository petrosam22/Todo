 
    $(document).ready(function() {
        // AJAX request to add a new task
        $('#addTaskForm').submit(function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: '/tasks',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response && response.title && response.index) {
                        var taskItem = '<li><span>' + response.title + '</span><button class="deleteTaskBtn" data-task-id="' + response.index + '">Delete</button></li>';
                        $('#taskList').append(taskItem);
                        $('#addTaskForm')[0].reset();
                        alert(response.message);
                    } else {
                        alert('Invalid response format.');
                    }
                },
                error: function(xhr) {
                    alert(xhr.responseJSON.errors.title[0]);
                }
            });
        });

        // AJAX request to delete a task
        $(document).on('click', '.deleteTaskBtn', function() {
            var taskId = $(this).data('task-id');
            var listItem = $(this).closest('li');

            $.ajax({
                url: '/tasks/' + taskId,
                type: 'DELETE',
                success: function(response) {
                    listItem.remove();
                    alert(response.message);
                },
                error: function(xhr) {
                    alert(xhr.responseJSON.error);
                }
            });
        });
    });



    $(document).on('click', '.deleteTaskBtn', function() {
        var taskId = $(this).data('task-id');
        var listItem = $(this).closest('li');

        // Get the CSRF token value from the page's meta tag
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '/tasks/' + taskId,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the request headers
            },
            success: function(response) {
                listItem.remove();
                alert(response.message);
            },
            error: function(xhr) {
                alert(xhr.responseJSON.error);
            }
        });
    });





    function saveTasksToLocalStorage(tasks) {
        localStorage.setItem('tasks', JSON.stringify(tasks));
    }
    
    function getTasksFromLocalStorage() {
        const tasks = localStorage.getItem('tasks');
        return tasks ? JSON.parse(tasks) : [];
    }
    
    // Function to handle task creation, edit, and deletion
    function handleTaskChanges() {
        // ... existing code for adding/editing/deleting tasks ...
    
        // After each change, save tasks to local storage
        saveTasksToLocalStorage(tasks);
    }
    // Backup tasks to local storage
document.getElementById('backupBtn').addEventListener('click', function () {
    const tasks = getTasksFromLocalStorage();
    localStorage.setItem('taskBackup', JSON.stringify(tasks));
    alert('Tasks backed up successfully!');
});

// Restore tasks from local storage backup
document.getElementById('restoreBtn').addEventListener('click', function () {
    const backup = localStorage.getItem('taskBackup');
    if (backup) {
        const tasks = JSON.parse(backup);
        saveTasksToLocalStorage(tasks);
        // Reload the page or update the task list display as needed
        location.reload();
    } else {
        alert('No backup found!');
    }
});