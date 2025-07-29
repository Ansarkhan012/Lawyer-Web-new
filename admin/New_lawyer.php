<?php

include_once '../config/config.php'; 

$query = "SELECT * FROM lawyers WHERE status = 'pending'";
$result = mysqli_query($conn, $query);
?>

<h2>New Lawyer Requests</h2>
<table border="1" cellpadding="10">
  <tr>
    <th>Name</th>
    <th>Email</th>
    <th>Experience</th>
    <th>CV</th>
    <th>Action</th>
  </tr>

  <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
      <td><?= $row['name']; ?></td>
      <td><?= $row['email']; ?></td>
      <td><?= $row['experience']; ?></td>
      <td><a href="../uploads/licenses/<?= $row['licence_file']; ?>" target="_blank">View CV</a></td>
      <td>
        <a href="approve_lawyer.php?id=<?= $row['id']; ?>"> Approve</a> |
        <a href="reject_lawyer.php?id=<?= $row['id']; ?>"> Reject</a>
      </td>
    </tr>
  <?php } ?>
</table>
