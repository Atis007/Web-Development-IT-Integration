<?php
session_start();
include "includes/functions.php";
require "includes/header.php";
$pdo = $GLOBALS['pdo'];
$user = assertAuthenticated($pdo);
?>
<nav class="navbar navbar-expand-lg border border-dark rounded mb-4">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarText">
            <?php
            if($_SESSION["role"] !== 'user'){
                echo "<ul class=\"navbar-nav me-auto mb-2 mb-lg-0\">
                        <li class=\"nav-item\">
                            <a class=\"nav-link\" href=\"all_users.php\">All Users</a>
                        </li>
                        <li class=\"nav-item\">
                            <a class=\"nav-link\" href=\"edit_users.php\">Edit Users</a>
                        </li>
                      </ul>";
            } else {
                echo "<ul class=\"navbar-nav me-auto mb-2 mb-lg-0\">
                        <li class=\"nav-item\">
                            <a class=\"nav-link\" href=\"new_task.php\">Add new task</a>
                        </li>
                        <li class=\"nav-item\">
                            <a class=\"nav-link\" href=\"my_tasks.php\">My tasks</a>
                        </li>
                      </ul>";
            }
            ?>

            <span class="text-white">
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </span>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
