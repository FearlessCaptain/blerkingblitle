<?php

include_once 'includes\deleteThread-inc.php';

// load threads for the main forum page
// id here refers to the thread id
function getAllThreads($conn, $role){

  if ($role > 3){
    $sql = "SELECT * FROM Threads";
  } else {
    $sql = "SELECT * FROM Threads WHERE Deleted = '0'";
  }

  $result = mysqli_query($conn, $sql);

  while ($row = mysqli_fetch_assoc($result)) {
    echo '

      <div class="forum-thread">
        <p class="forum-owner"> Posted by <a href="profile.php?='.$row['OwnerID'].'">' .$row['Username']. '</a> on '.$row['Date'].'</p>
        <a href="viewthread.php?threadid='.$row['ID'].'">
          <p class="forum-title">'.$row['Title'].'</p>';

    if ($role > 1 && $row['Deleted'] == 0){
      echo '<a href="deleteThread.php?threadid='.$row['ID'].'">DELETE THIS</a>';
    //  echo'<form method="POST" action="'.deleteThread($conn, $role, $row['id']).'"><button class="nav-button" type="submit" name="delete">DELETE THIS</button></form>';
    }
    if ($role > 3 && $row['Deleted'] == 1){
      echo '<br> --DELETED THREAD--';
    }
    echo '
    </div> </a>';
  }
}


// echos thread title of a given threadID
function getTitle($conn, $threadID){
  $sql = "SELECT Title FROM Threads WHERE ID = '$threadID'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  return $row['Title'];
}

// echos username/nickname of a given threadID
function getPoster($conn, $threadID){
  $sql = "SELECT Username FROM Threads WHERE ID = '$threadID'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  echo $row['Username'];
}

// returns the location of a users avatar
function getAvatar($conn, $userid){
  $sql = "SELECT Avatar FROM Users WHERE ID = '$userid'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  return 'uploads/'.$row['Avatar'];
}

function getRole($conn, $userid){
  $sql = "SELECT RoleName FROM Users WHERE ID = '$userid'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  return $row['RoleName'];
}

function getFlavorText($conn, $userid){
  $sql = "SELECT FlavorText FROM Users WHERE ID = '$userid'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  return $row['FlavorText'];
}

// echos just one comment
function getComment($conn, $postid){
  $sql = "SELECT Body, Username, PostDate FROM Posts WHERE ID = '$postid'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
//  echo '<p>'$row['owner_name'] $row['body'];

  echo '
    <div class="post-view">
      <div class="infoholder-view">
        <img class="avatar-view" src="'.getAvatar($conn, $row['OwnerID']).'">
        <p class="author-view">'.$row['Username']. ' on '.$row['PostDate'].'</p>
        <p class="memberText-view">Mold Member</p>
      </div>
      <p class="text">'.nl2br($row['Body']).'</p>
    </div>
    <br>';

}

// echos the posts of a given threadID
// id here refers to the id of a comment in a thread
function getThread($conn, $threadID, $role){

  // load ALL comments for mega admin and above
  // break down of roles:
  // 0 for user, 1 for gold, 2 for mod, 3 for admin, 4 for mega admin, big
  // number for owner or hyper admin
  if ($role > 3){
    $sql = "SELECT * FROM Posts WHERE ThreadID = '$threadID'";
  } else {
    $sql = "SELECT * FROM Posts WHERE ThreadID = '$threadID' AND Deleted = '0'";
  }
  $result = mysqli_query($conn, $sql);
  //$row = mysqli_fetch_assoc($result);
  while ($row = mysqli_fetch_assoc($result)) {
    echo '
      <div class="post-view">
        <div class="infoholder-view">
          <p class="postdate-view">'.$row['PostDate'].'</p>
          <img class="avatar-view" src=" '. getAvatar($conn, $row['OwnerID']).'">
          <p class="author-view">'.$row['Username'].'</p>
          <p class="author-view">'. getRole($conn, $row['OwnerID']).'</p>
          <p class="memberText-view">'. getFlavorText($conn, $row['OwnerID']).'</p>
        </div>
        <p class="text">'.$row['Body'].'</p>';
    // so mods can delete posts
    if ($role > 1 && $row['Deleted'] == 0){
      echo '<a href="deletePost.php?postid='.$row['ID'].'">DELETE THIS</a>';
    }
    // so hyper admins can see the posts
    if ($role > 3  && $row['Deleted'] == 1){
      echo ' --DELETED POST--';
    }
    echo '</div>
    <br>';
  }
}


// echos the posts of a users
// used on the profile page
function getPostsByUID($conn, $id, $role){

  // load ALL comments for mega admin and above
  // break down of roles:
  // 0 for user, 1 for gold, 2 for mod, 3 for admin, 4 for mega admin, big
  // number for owner or hyper admin
  if ($role > 3){
    $sql = "SELECT * FROM Posts WHERE OwnerID = '$id'";
  } else {
    $sql = "SELECT * FROM Posts WHERE OwnerID = '$id' AND Deleted = '0'";
  }
  $result = mysqli_query($conn, $sql);
  //$row = mysqli_fetch_assoc($result);
  while ($row = mysqli_fetch_assoc($result)) {
    echo '
      <div class="post-view">
        <div class="infoholder-view">
        <p class="postdate-view">'.$row['PostDate'].'</p>
        <img class="avatar-view" src=" '. getAvatar($conn, $row['OwnerID']).'">
        <p class="author-view">'.$row['Username'].'</p>
        <p class="author-view">'. getRole($conn, $row['OwnerID']).'</p>
        <p class="memberText-view">'. getFlavorText($conn, $row['OwnerID']).'</p>
        </div>
        <p class="text">'.$row['Body'].'</p>';
        
    // so mods can delete posts
    if ($role > 1 && $row['Deleted'] == 0){
      echo '<a href="deletePost.php?postid='.$row['ID'].'">DELETE THIS</a>';
    }
    // so hyper admins can see the posts
    if ($role > 3  && $row['Deleted'] == 1){
      echo ' --DELETED POST--';
    }
    echo '</div>
    <br>';
  }
}
