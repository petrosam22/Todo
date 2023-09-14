<!-- Add New Task Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/todo.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form id="addTaskForm">
        @csrf

    <div class="form__group field">
        <input type="input" class="form__field" placeholder="Task Title" name="title" id='title' required />
        <label for="name" class="form__label">Name</label>
 
    <button type="submit" class="added">Add Task</button>
 

      </div>
    </form>
 
 
    <div class="container mt-3 bg-dark" style="    WIDTH: 70%;
    ">
        <table class="table">
          <thead>
            <tr>
              <th>Title</th>
               <th>Delete</th>
              <th>Backup</th>
              <th>Restore</th>
              
            </tr>
          </thead>
          <tbody>
            @foreach($tasks as $index => $task)

            <tr>
             <th class="text-white">{{ $task['title'] }}</th>
             <th>            <button class="deleteTaskBtn" data-task-id="{{ $index }}">Delete</button>
             </th>
             
             
            </tr>
            
            @endforeach
            <button id="backupBtn">Backup Tasks</button>

            <button id="restoreBtn">Restore Tasks</button>
          </tbody>
        </table>
      </div>   
      
 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  


<script src="js/todo.js"></script>
</body>
</html>
