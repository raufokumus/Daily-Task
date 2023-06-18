<?php
session_start();

// Oturum kontrolü
if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}

// Veritabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "site";

$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Oturum kullanıcısı
$username = $_SESSION['username'];

// Görev ekleme formu gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $task = $_POST['task'];
  $taskDate = $_POST["task_date"];
  $due_date = $_POST["due_date"];

    // Görevi veritabanına ekle
    $sql = "INSERT INTO tasks (username, task, created_at, task_date, due_date) VALUES ('$username', '$task', NOW(), '$taskDate', '$due_date')";

  if ($conn->query($sql) === TRUE) {
    // Başarılı bir şekilde eklendi
  } else {
    echo "Error adding task: " . $conn->error;
  }
}

// Veritabanından günlük görevleri al
$sql = "SELECT * FROM tasks WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

// $dailyTasks dizisini oluştur
$dailyTasks = array();
while ($row = mysqli_fetch_assoc($result)) {
  $dailyTasks[] = $row;
}


$conn->close();
?>
<!DOCTYPE html>
<html>
<head>  
  <title>Ana Sayfa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"></head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
  <link rel="shortcut icon" href="main.svg">
  <style>
    .sidebar {
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      padding: 48px 0;
      width: 240px;
      background-color: #f8f9fa;
    }
  </style>
</head>
<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap shadow p-1">
        <div class="navbar-nav px-3">
            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="flex-shrink-0">
                <a href="#settings" class="d-block link-dark text-decoration-none text-light" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                     Welcome <?php echo $username; ?>
                </a>

            </div>
        </div>

      <div class="navbar-nav">
        <div class="nav-item text-nowrap">
          <a class="nav-link px-3" href="logout.php">Sign out</a>
        </div>
      </div>
    </header>

  <div class="d-flex mx-4">
    <div class="content">
        <div class="container text-left">
            <div class="row">
              <div class="col col-lg-6">
                <div class="mt-4 card text-center shadow p-3 mb-5 bg-body-tertiary rounded  ">
                    <div class="px-5 mt-4 d-flex">
                      <div class="card-body">
                        <h3 class="card-title title">
                          Daily Task
                          <button type="button" class="btn btn-outline-success mx-1 btn-sm p-1" data-bs-toggle="modal" data-bs-target="#taskModal">
                            <i class="bi bi-plus-circle"></i>
                          </button>
                      </h3>
                      </div>
                    </div>
    
                  <div class="p-1">
                  <?php if (count($dailyTasks) > 0): ?>
                    <table class="table my-2">
                        <thead class="table-dark">
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Task</th>
                              <th scope="col">Start</th>
                              <th scope="col">Termination</th>
                              <th scope="col">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                      <?php foreach ($dailyTasks as $task): ?>
                        <tr>
                        <th scope="col"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text align-text-bottom" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></th>
                              <th scope="col"><?php echo $task['task']; ?></th>
                              <th scope="col"><?php echo $task['task_date']; ?></th>
                              <th scope="col"><?php echo $task['due_date']; ?></th>
                              <th scope="col">
                              <button type="button" class="btn btn-outline-info p-1 " data-bs-toggle="modal" data-bs-target="#editTaskModal" data-task-id="<?php echo $task['id']; ?>" data-task="<?php echo $task['task']; ?>">
                                <i class="bi bi-gear-fill"></i>
                              </button>
                              <button type="button" class="btn btn-outline-danger p-1 " data-bs-toggle="modal" data-bs-target="#deleteTaskModal" data-task-id="<?php echo $task['id']; ?>">
                                <i class="bi bi-trash2"></i>
                              </button>
                              </th>
                        </tr>
                      <?php endforeach; ?>
                        </tbody>
                      </table>
                  <?php else: ?>
                    <p>There are no daily task.</p>
                  <?php endif; ?>
                    
                  </div>
                </div>

              </div>
              <div class="col col-lg-6 my-4">
                <div class="card shadow p-3 mb-5 bg-body-tertiary rounded" style="width: 156%;">
                    <div class="card-body">
                    <div id="calendar"></div>
                    <script>
                      $(document).ready(function() {
                        // Takvimin oluşturulması
                        $('#calendar').fullCalendar({
                          header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay'
                          },
                          defaultView: 'month',
                          editable: false,
                          events: 'get_events.php' // Görevleri alacak olan PHP dosyası
                        });
                      });
                    </script>
                    </div>
                </div>
              </div>
            </div>
        </div>
       

      <!-- Görev Ekleme Modal -->
      <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="taskModalLabel">Add Task</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="POST">
                <div class="mb-3">
                  <label for="task" class="form-label">Task Content</label>
                  <input type="text" id="task" name="task"class="form-control m-1" placeholder="Task" required>
                </div>
                <div class="mb-3">
                  <label for="task_date" class="form-label">Start Date</label>
                  <input type="datetime-local" id="task_date" class="form-control m-1" name="task_date" placeholder="Date" required>
                </div>
                <div class="mb-3">
                  <label for="due_date" class="form-label">Due Date</label>
                  <input type="datetime-local" id="due_date" class="form-control m-1" name="due_date" placeholder="Date" required>
                </div>
                
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Görev Düzenleme Modal -->
      <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="POST" id="editTaskForm">
                <div class="mb-3">
                  <label for="editedTask" class="form-label">Task Content:</label>
                  <input type="text" id="editedTask" name="editedTask" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label for="task_date" class="form-label">Start Date</label>
                  <input type="datetime-local" id="task_date" class="form-control m-1" name="task_date" placeholder="Date" required>
                </div>
                <div class="mb-3">
                  <label for="due_date" class="form-label">Due Date</label>
                  <input type="datetime-local" id="due_date" class="form-control m-1" name="due_date" placeholder="Date" required>
                </div>
                <input type="hidden" id="editedTaskId" name="editedTaskId">
                <button type="submit" class="btn btn-primary">Save</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Görev Silme Modal -->
      <div class="modal fade" id="deleteTaskModal" tabindex="-1" aria-labelledby="deleteTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteTaskModalLabel">Delete Task</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete the task??</p>
              <form method="POST" id="deleteTaskForm">
                <input type="hidden" id="deletedTaskId" name="deletedTaskId">
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js" integrity="sha384-gdQErvCNWvHQZj6XZM0dNsAoY4v+j5P1XDpNkcM3HJG1Yx04ecqIHk7+4VBOCHOG" crossorigin="anonymous"></script><script src="dashboard.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script></body>

  <script>
    // Görev Düzenleme Modalı için verileri doldurma
    var editTaskModal = document.getElementById('editTaskModal');
    editTaskModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      var taskId = button.getAttribute('data-task-id');
      var task = button.getAttribute('data-task');
      var editedTaskForm = editTaskModal.querySelector('#editTaskForm');
      var editedTaskInput = editTaskModal.querySelector('#editedTask');
      var editedTaskIdInput = editTaskModal.querySelector('#editedTaskId');
      editedTaskForm.action = 'edit_task.php';
      editedTaskInput.value = task;
      editedTaskIdInput.value = taskId; 
    });

    // Görev Silme Modalı için veriyi doldurma
    var deleteTaskModal = document.getElementById('deleteTaskModal');
    deleteTaskModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      var taskId = button.getAttribute('data-task-id');
      var deletedTaskForm = deleteTaskModal.querySelector('#deleteTaskForm');
      var deletedTaskIdInput = deleteTaskModal.querySelector('#deletedTaskId');
      deletedTaskForm.action = 'delete_task.php';
      deletedTaskIdInput.value = taskId;
    });
  </script>
</body>
</html>
