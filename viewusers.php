<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 0;
      
    }

    h3 {
      font-size: 20px;
      text-align: center;
    }

    .container {
      max-width: 1200px;
      margin: 20px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    .edit-link, .delete-link {
      text-decoration: none;
      padding: 5px 10px;
      border-radius: 5px;
      transition: background-color 0.3s, color 0.3s;
    }

    .edit-link {
      background-color: #007bff;
      color: #fff;
    }

    .edit-link:hover {
      background-color: #0056b3;
    }

    .delete-link {
      background-color: #ff0000;
      color: #fff;
    }

    .delete-link:hover {
      background-color: #ff3333;
    }
  </style>
</head>
<body>
  <div class="container">
    <h3>User Table</h3>
    <table>
      <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
      <?php
      require_once("connection.php");
      $sql = "SELECT * FROM users";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<tr>
                <td>{$row['user_id']}</td>
                <td>{$row['username']}</td>
                <td>{$row['email']}</td>
                <td><a class='edit-link' href='editusers.php?id={$row['user_id']}'>Edit</a></td>
                <td><a class='delete-link' href='deleteusers.php?id={$row['user_id']}'>Delete</a></td>
                </tr>";
        }
      } else {
        echo "<tr><td colspan='5'>No results</td></tr>";
      }
      $conn->close();
      ?>
    </table>
  </div>
</body>
</html>
