<!-- التاكد من انشاء حساب -->
<?php
session_start();

// انقل السمتخدم لصفحه تسجيل الدخول اذا لم يسجل الدخول في الجلسه
if (!isset($_SESSION['email'], $_SESSION['name'],$_SESSION['id'])) {
    header("Location: Login.php");
    exit();
}



// الاتصال بقاعده البيانات
require_once 'DB.php';
require_once 'Validation.php';

$user_id = $_SESSION['id'];

if (isset($_POST["addtask"])) {
    $task = Validation::data($_POST["task"]); 

    if (!empty($task)) { 

        $stmt = $conn->prepare("INSERT INTO tasks (task, user_id) VALUES (?, ?)");
        $stmt->bind_param("si", $task, $user_id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: index.php");
    exit();
}

// عرض المهام
$stmt = $conn->prepare("SELECT * FROM `tasks` WHERE `user_id` = ? ORDER BY `Task_ID` DESC"); 
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result(); 

if (isset($_GET["Delete"])) {
    $id = $_GET["Delete"];
    $stmt = $conn->prepare("DELETE FROM `tasks` WHERE `Task_ID` = ? AND `user_id` = ?");
    $stmt->bind_param("ii", $id, $user_id); 
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit();
}


if (isset($_GET["Complete"])) {
    $id = $_GET["Complete"];
    $stmt = $conn->prepare("UPDATE `tasks` SET `status` = 'Complete' WHERE `Task_ID` = ? AND `user_id` = ?"); 
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <a href="actions/logout_action.php" class="btn-logout">Logout</a>
        <div class="todo-card">
            <h2>Todo List</h2>

            <form action="index.php" method="post" class="todo-form">
                <input type="text" name="task" placeholder="Enter new task:" id="task-input">
                
                <button type="submit" name="addtask" id="add-btn">Add Task</button>
            </form>

            <ul class="task-list">
                <?php while($run = $result->fetch_assoc()): ?> 


                    <li class="task-item <?php echo $run["status"]; ?>">
                        <span class="task-text"><?php echo htmlspecialchars($run["task"]); ?></span>
                        
                        <div class="actions">
                            <a href="index.php?Complete=<?php echo $run["Task_ID"]; ?>" class="btn-complete">Complete</a>
                            <a href="index.php?Delete=<?php echo $run["Task_ID"]; ?>" class="btn-delete">Delete</a>
                        </div>
                    </li>
                <?php endwhile ?>
            </ul>
        </div>
    </div>
</body>
</html>
