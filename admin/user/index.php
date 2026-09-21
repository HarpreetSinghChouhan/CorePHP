<?php
// admin/index.php
// $_SESSION_ROLE_OVERRIDE = 'Admin'; // demo only
require_once __DIR__ . '/../common/header.php';

require_once __DIR__ . '/../common/sidebar.php';
?>

<div class="admin-main">
    <script src="/CorePHP/admin/assets/js/user.js" defer></script>
    <?php require_once __DIR__ . '/../common/navbar.php'; ?>

    <div class="admin-content">
        <div class="panel">
            <div class="table-header" >
            <h1 class="center"> Users List</h1> <button class="btn create-link-btn"  >Add New User</button>

            </div>
            <table>
                <thead>
                    <tr><th>Serial No</th><th>Name</th><th>Email</th><th>role</th><th>age</th><th>gender</th><th>Action</th></tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT * FROM user WHERE role='user'AND Is_deleted='0'";
                $result = mysqli_query($conn, $query);
                $SerialNo = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr data-id ='" . $row["id"] . "'
                              data-name='" . htmlspecialchars($row["name"]) . "'
                              data-email='" . htmlspecialchars($row["email"]) . "'
                              data-age='" . htmlspecialchars($row["age"]) . "'
                              data-gender='" . htmlspecialchars($row["gender"]) . "'>
                        <td>" . $SerialNo . "</td>
                        <td class='user-name'>" . $row["name"] . "</td>
                        <td  class='user-email' >" . $row["email"] . "</td>
                        <td>" . $row["role"] . "</td>
                        <td>" . $row["age"] . "</td>
                        <td>" . $row["gender"] . "</td>
                        <td class='action-cell'>
                            <button type='button' class='btn-icon edit-link-btn edit-user' title='Edit'>
                                <i class='fa-solid fa-pen'></i>
                            </button>
                            <button type='button' class='btn-icon delete-user' title='Delete'>
                                <i class='fa-solid fa-trash'></i>
                            </button>
                        </td>
                    </tr>";
                    $SerialNo++;
                }
                ?>
                </tbody>
            </table>
        </div>

        <!-- =========================
             EDIT USER MODAL
        ========================== -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close-modal">&times;</span>
                <h2>Edit User</h2>

                <form id="editUserForm">
                    <input type="hidden" id="editUserId" name="id">

                    <div class="form-group">
                        <label for="editName">Name</label>
                        <input type="text" id="editName" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" id="editEmail" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="editAge">Age</label>
                        <input type="number" id="editAge" name="age" required>
                    </div>

                    <div class="form-group">
                        <label for="editGender">Gender</label>
                        <select id="editGender" name="gender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
<?php require_once __DIR__ . '/../common/footer.php'; ?>