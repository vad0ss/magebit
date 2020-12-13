<?php
   include 'vendor/autoload.php';
   use App\Controllers\IndexController;

   ini_set('display_error', 1);
   $index = new IndexController();

   $page = isset($_GET['page']) ? $_GET['page'] : 1;

   // Get total number of pages
   $totalPage = intval(($index->mailsCount - 1) / $index->paginateLimit) + 1;

   // start page
   $page = intval($page);

   if(empty($page) or $page < 0) $page = 1;
   if($page > $totalPage) $page = $totalPage;

   $offset = $index->paginateLimit * ($page - 1);

   // sort
   if($_GET['sort'] === 'name') {
       $stmt = $index->sortByNameDate('name');
   } elseif ($_GET['sort'] === 'date') {
       $stmt = $index->sortByNameDate('date');
   } else {
       $stmt = $index->getMailsForPaginate($offset, $index->paginateLimit);
   }

   $providersStmt = $index->getProviders();

   $emails = array();
   $providers = array();


while ($email = $stmt->fetch(PDO::FETCH_LAZY))
{
     $a = array();

     $a['id'] = $email->id;
     $a['email'] = $email->email;
     $a['created'] = $email->created;
     $a['provider'] = $email->provider;

     $emails[] = $a;
}

if(isset($_GET['filter'])){
    $emails = $index->providerFilter($emails, $_GET['filter']);
} elseif(isset($_GET['wpfilter'])) {
    $emails = $index->withoutProviderFilter($emails, $_GET['wpfilter']);
} elseif(isset($_GET['search'])) {
    $emails = $index->search($_GET['search']);
}

while ($provider = $providersStmt->fetch(PDO::FETCH_LAZY))
{
    $a = array();
    $a['provider'] = $provider->provider;
    $providers[] = $a;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="/assets/favicon.ico">
    <link href="assets/style.css" rel="stylesheet">
    <title>Pineapple Subscribe Backend</title>
</head>
<body>

   <p><h2>Mails Subscribe List</h2></p>

   <div class="search_block">
       <form method="post" action="routes/backend_posts.php">
           <input type="text" name="search" value="" placeholder="Please enter search text">
           <input type="submit" value="Search">
       </form>
   </div>

   <hr />

   <div class="sort_filters_block">

         <div class="sort_form">
            <form method="post" action="routes/backend_posts.php">
                <label for="sort">Sort by:</label>

                <select name="sortbydateorname" id="sort">
                    <option value="name">Name</option>
                    <option value="date">Date</option>
                </select>

                <input type="submit" value="Sort">
            </form>
         </div>

         <div class="filters">

             <form method="post" action="routes/backend_posts.php">
                 <input type="hidden" name="gmailfilter" value="Gmail">
                 <input type="submit" value="Gmail">
             </form>

             <form method="post" action="routes/backend_posts.php">
                 <input type="hidden" name="yahoofilter" value="Yahoo">
                 <input type="submit" value="Yahoo">
             </form>

             <form method="post" action="routes/backend_posts.php">
                 <input type="hidden" name="outlookfilter" value="Outlook">
                 <input type="submit" value="Outlook">
             </form>

             <form method="post" action="routes/backend_posts.php">
                 <label for="sort">Without other providers:</label>

                 <select name="wpfilter" id="without_other_providers">
                   <?
                     foreach ($providers as $provider)
                     {
                       echo "<option value='$provider[provider]'>". $provider['provider'] . "</option>";
                     }
                   ?>
                 </select>

                 <input type="submit" value="Filter">
             </form>

         </div>

   </div>

   <hr />

   <form action="inc/actions/actions.php" method="post">

   <table>

       <thead>
         <tr>
           <th>Check</th>
           <th>Id</th>
           <th>Email</th>
           <th>Provider</th>
           <th>Date</th>
         </tr>
       </thead>

       <tbody>

       <?

          foreach ($emails as $email)
          {
              echo "<tr>";

              echo "<td><input type='checkbox' name='check_list[]' value = '". $email['id'] . " ' > </td> ";
              echo "<td>" . $email['id'] . "</td>";
              echo "<td>" . $email['email'] . "</td>";
              echo "<td>" . $email['provider'] . "</td>";
              echo "<td>" . $email['created'] . "</td>";

              echo "</tr>";
          }

       ?>
       </tbody>

     </table>
       <div class="actions">

           <select name="actions" id="actions_select">
               <option value="csv">CSV Convert</option>
               <option value="delete">Delete checked</option>
           </select>

           <input type="submit" value="Action">
       </div>
   </form>

  <div class="center">
      <div class="pagination">
        <?php
            if ($page != 1) $pervpage = '<a href= ./index.php?page=1><<</a>
                               <a href= ./index.php?page='. ($page - 1) .'><</a> ';
            if ($page != $totalPage) $nextpage = ' <a href= ./index.php?page='. ($page + 1) .'>></a>
                                   <a href= ./index.php?page=' .$totalPage. '>>></a>';

            if($page - 2 > 0) $page2left = ' <a href= ./index.php?page='. ($page - 2) .'>'. ($page - 2) .'</a>';
            if($page - 1 > 0) $page1left = '<a href= ./index.php?page='. ($page - 1) .'>'. ($page - 1) .'</a>';
            if($page + 2 <= $totalPage) $page2right = '<a href= ./index.php?page='. ($page + 2) .'>'. ($page + 2) .'</a>';
            if($page + 1 <= $totalPage) $page1right = '<a href= ./index.php?page='. ($page + 1) .'>'. ($page + 1) .'</a>';

            echo $pervpage.$page2left.$page1left.'<a>'.$page.'</a>'.$page1right.$page2right.$nextpage;

        ?>
      </div>
  </div>
</body>
</html>