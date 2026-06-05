<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

if (!$_USER->Logged_In) { header("location: /login"); exit(); }

$_USER->get_info();

if (!isset($_GET['d'])) {
  $Date = "w";
}
elseif (isset($_GET['d']) && $_GET['d'] == "d") {
  $Date = "d";
}
elseif (isset($_GET['d']) && $_GET['d'] == "w") {
  $Date = "w";
}
elseif (isset($_GET['d']) && $_GET['d'] == "m") {
  $Date = "m";
}
elseif (isset($_GET['d']) && $_GET['d'] == "a") {
  $Date = "a";
}

if (isset($Date) && $Date == "d") {
$StartDate = date("Y-m-d",strtotime("-1 day"));
$DBDate = "DATE_SUB(NOW(), INTERVAL 1 DAY)";
}
elseif (isset($Date) && $Date == "w") {
$StartDate = date("Y-m-d",strtotime("-1 week"));
$DBDate = "DATE_SUB(NOW(), INTERVAL 1 WEEK)";
}
elseif (isset($Date) && $Date == "m") {
$StartDate = date("Y-m-d",strtotime("-1 month"));
$DBDate = "DATE_SUB(NOW(), INTERVAL 1 MONTH)";
}
elseif (isset($Date) && $Date == "a") {
$StartDate = date("Y-m-d",strtotime((string) $_USER->Info['registration_date']));
$DBDate = "DATE_SUB(NOW(), INTERVAL 100 YEAR)";
}
else {
  $StartDate = date("Y-m-d",strtotime(strtotime("-1 week")));
  $DBDate = "DATE_SUB(NOW(), INTERVAL 1 WEEK)";
}

if (!isset($_GET['v'])) {
if (!isset($_GET['page'])) {
  $Daily_Views = $DB->execute("SELECT IFNULL(B.Total,0) AS Total, A.dates AS Date FROM
(SELECT ADDDATE('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) as dates FROM
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4) A 
LEFT JOIN
(SELECT
  sum(views_day.views) as total,
  DATE(views_day.submit_date) as date
FROM views_day INNER JOIN videos ON videos.url = views_day.url
WHERE videos.uploaded_by = '$_USER->Username' AND DATE(views_day.submit_date) between date('$StartDate') and date(curdate())
GROUP BY CAST(views_day.submit_date AS date)) B 
ON A.dates=B.date  
WHERE A.dates BETWEEN '$StartDate' and curdate()
ORDER BY `Date` ASC");

$Daily_Views_Num = $DB->execute("SELECT videos.title as title, views_day.url, sum(views_day.views) as total FROM views_day INNER JOIN videos ON videos.url = views_day.url WHERE videos.uploaded_by = :USERNAME AND views_day.submit_date > :DATE GROUP BY views_day.url ORDER BY total DESC LIMIT 10", false, [":USERNAME" => $_USER->Username, ":DATE" => $DBDate]);

$Daily_Views_Total = (int)$DB->execute("SELECT sum(views_day.views) as amount FROM views_day INNER JOIN videos ON videos.url = views_day.url WHERE videos.uploaded_by = :USERNAME AND views_day.submit_date > :DATE", true, [":USERNAME" => $_USER->Username, ":DATE" => $DBDate])["amount"];

$Countries = $DB->execute("SELECT users.i_country as country, count(users.i_country) as amount FROM users INNER JOIN subscriptions ON subscriptions.subscription = :USERNAME WHERE subscriptions.subscriber = users.username AND users.i_country != '' AND subscriptions.submit_date > :DATE GROUP BY users.i_country ORDER BY amount DESC", false, [":USERNAME" => $_USER->Username, ":DATE" => $DBDate]);

$Age = $DB->execute("SELECT users.i_age as age, count(users.i_age) as amount FROM users INNER JOIN subscriptions ON subscriptions.subscription = :USERNAME WHERE subscriptions.subscriber = users.username AND users.i_age != '0000-00-00' AND subscriptions.submit_date > :DATE GROUP BY users.i_country ORDER BY amount DESC", false, [":USERNAME" => $_USER->Username, ":DATE" => $DBDate]);

$Age_13_17 = 0;
$Age_18_24 = 0;
$Age_25_34 = 0;
$Age_35_44 = 0;
$Age_45_54 = 0;
$Age_55_64 = 0;
$Age_65 = 0;

if ($Age) {
  foreach ($Age as $Age_Num) {
    if (ageCalculator($Age_Num['age']) < 18) {
      $Age_13_17 += $Age_Num['amount'];
    }
    elseif (ageCalculator($Age_Num['age']) >= 18 && ageCalculator($Age_Num['age']) <= 24) {
      $Age_18_24 += $Age_Num['amount'];
    }
    elseif (ageCalculator($Age_Num['age']) >= 25 && ageCalculator($Age_Num['age']) <= 34) {
      $Age_25_34 += $Age_Num['amount'];
    }
    elseif (ageCalculator($Age_Num['age']) >= 35 && ageCalculator($Age_Num['age']) <= 44) {
      $Age_35_44 += $Age_Num['amount'];
    }
    elseif (ageCalculator($Age_Num['age']) >= 45 && ageCalculator($Age_Num['age']) <= 54) {
      $Age_45_54 += $Age_Num['amount'];
    }
    elseif (ageCalculator($Age_Num['age']) >= 55 && ageCalculator($Age_Num['age']) <= 64) {
      $Age_55_64 += $Age_Num['amount'];
    }
    elseif (ageCalculator($Age_Num['age']) >= 65) {
      $Age_65 += $Age_Num['amount'];
    }
  }

  $Age_Total = $Age_13_17 + $Age_18_24 + $Age_25_34 + $Age_35_44 + $Age_45_54 + $Age_55_64 + $Age_65;

  if ($Age_Total > 0) {
    $Age_13_17 = round($Age_13_17 / $Age_Total * 100,1);
    $Age_18_24 = round($Age_18_24 / $Age_Total * 100,1);
    $Age_25_34 = round($Age_25_34 / $Age_Total * 100,1);
    $Age_35_44 = round($Age_35_44 / $Age_Total * 100,1);
    $Age_45_54 = round($Age_45_54 / $Age_Total * 100,1);
    $Age_55_64 = round($Age_55_64 / $Age_Total * 100,1);
    $Age_65 = round($Age_65 / $Age_Total * 100,1);
  }
}

$Gender = $DB->execute("SELECT users.i_gender as gender, count(users.i_gender) as amount FROM users INNER JOIN subscriptions ON subscriptions.subscription = :USERNAME WHERE subscriptions.subscriber = users.username AND users.i_gender != 0 AND subscriptions.submit_date > :DATE GROUP BY users.i_gender ORDER BY amount DESC",false, [":USERNAME" => $_USER->Username, ":DATE" => $DBDate]);

$Gender_Total = $DB->execute("SELECT count(users.i_gender) as amount FROM users INNER JOIN subscriptions ON subscriptions.subscription = :USERNAME WHERE subscriptions.subscriber = users.username AND users.i_gender != 0 AND subscriptions.submit_date > :DATE",true,[":USERNAME" => $_USER->Username, ":DATE" => $DBDate])['amount'];

if ($Gender_Total > 0) {
  foreach ($Gender as $Gender_Num) {
    if ($Gender_Num['gender'] == 1) {
      $Gender_1 = ($Gender_Num['amount'] / $Gender_Total) * 100;
    }
    else if ($Gender_Num['gender'] == 2) {
      $Gender_2 = ($Gender_Num['amount'] / $Gender_Total) * 100;
    }
  }
}
else {
  $Gender_1 = 0;
  $Gender_2 = 0;
}

}
if (isset($_GET['page']) && $_GET['page'] == "views") {
$Daily_Subs = $DB->execute("SELECT IFNULL(B.Total,0) AS Total, A.dates AS Date FROM
(SELECT ADDDATE('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) as dates FROM
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4) A 
LEFT JOIN
(SELECT
  COUNT(*) as total,
  DATE(submit_date) as date
FROM subscriptions
where 
  subscription = '$_USER->Username' AND DATE(submit_date) between date('$StartDate') and date(curdate())
GROUP BY CAST(submit_date AS date)) B 
ON A.dates=B.date  
WHERE A.dates BETWEEN '$StartDate' and curdate()
ORDER BY `Date` ASC");

for ($i = 1; $i <= $DB->Row_Num - 1; $i++) {
    $n = $i - 1;
    $Daily_Subs[$i]['Total'] += $Daily_Subs[$n]['Total'];
}

$Daily_Views = $DB->execute("SELECT IFNULL(B.Total,0) AS Total, A.dates AS Date FROM
(SELECT ADDDATE('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) as dates FROM
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4) A 
LEFT JOIN
(SELECT
  sum(views_day.views) as total,
  DATE(views_day.submit_date) as date
FROM views_day INNER JOIN videos ON videos.url = views_day.url
WHERE videos.uploaded_by = '$_USER->Username' AND DATE(views_day.submit_date) between date('$StartDate') and date(curdate())
GROUP BY CAST(views_day.submit_date AS date)) B 
ON A.dates=B.date  
WHERE A.dates BETWEEN '$StartDate' and curdate()
ORDER BY `Date` ASC");
$Daily_Views_Num = $DB->execute("SELECT videos.title as title, views_day.url, sum(views_day.views) as total FROM views_day INNER JOIN videos ON videos.url = views_day.url WHERE videos.uploaded_by = :USERNAME AND views_day.submit_date > :DATE GROUP BY views_day.url ORDER BY total DESC LIMIT 10", false, [":USERNAME" => $_USER->Username, ":DATE" => $DBDate]);

$Daily_Views_Total = (int)$DB->execute("SELECT sum(views_day.views) as amount FROM views_day INNER JOIN videos ON videos.url = views_day.url WHERE videos.uploaded_by = :USERNAME AND views_day.submit_date > :DATE", true, [":USERNAME" => $_USER->Username, ":DATE" => $DBDate])["amount"];
}

if (isset($_GET['page']) && $_GET['page'] == "demographics") {
$Age = $DB->execute("SELECT users.i_age as age, count(users.i_age) as amount FROM users INNER JOIN subscriptions ON subscriptions.subscription = :USERNAME WHERE subscriptions.subscriber = users.username AND users.i_age != '0000-00-00' AND subscriptions.submit_date > :DATE GROUP BY users.i_country ORDER BY amount DESC", false, [":USERNAME" => $_USER->Username, ":DATE" => $DBDate]);

$Age_13_17 = 0;
$Age_18_24 = 0;
$Age_25_34 = 0;
$Age_35_44 = 0;
$Age_45_54 = 0;
$Age_55_64 = 0;
$Age_65 = 0;

if ($Age) {

  foreach ($Age as $Age_Num) {
    if (ageCalculator($Age_Num['age']) < 18) {
      $Age_13_17 += $Age_Num['amount'];
    }
    elseif (ageCalculator($Age_Num['age']) >= 18 && ageCalculator($Age_Num['age']) <= 24) {
      $Age_18_24 += $Age_Num['amount'];
    }
    elseif (ageCalculator($Age_Num['age']) >= 25 && ageCalculator($Age_Num['age']) <= 34) {
      $Age_25_34 += $Age_Num['amount'];
    }
    elseif (ageCalculator($Age_Num['age']) >= 35 && ageCalculator($Age_Num['age']) <= 44) {
      $Age_35_44 += $Age_Num['amount'];
    }
    elseif (ageCalculator($Age_Num['age']) >= 45 && ageCalculator($Age_Num['age']) <= 54) {
      $Age_45_54 += $Age_Num['amount'];
    }
    elseif (ageCalculator($Age_Num['age']) >= 55 && ageCalculator($Age_Num['age']) <= 64) {
      $Age_55_64 += $Age_Num['amount'];
    }
    elseif (ageCalculator($Age_Num['age']) >= 65) {
      $Age_65 += $Age_Num['amount'];
    }
  }

  $Age_Total = $Age_13_17 + $Age_18_24 + $Age_25_34 + $Age_35_44 + $Age_45_54 + $Age_55_64 + $Age_65;

  if ($Age_Total > 0) {
    $Age_13_17 = round($Age_13_17 / $Age_Total * 100,1);
    $Age_18_24 = round($Age_18_24 / $Age_Total * 100,1);
    $Age_25_34 = round($Age_25_34 / $Age_Total * 100,1);
    $Age_35_44 = round($Age_35_44 / $Age_Total * 100,1);
    $Age_45_54 = round($Age_45_54 / $Age_Total * 100,1);
    $Age_55_64 = round($Age_55_64 / $Age_Total * 100,1);
    $Age_65 = round($Age_65 / $Age_Total * 100,1);
  }

}

$Gender = $DB->execute("SELECT users.i_gender as gender, count(users.i_gender) as amount FROM users INNER JOIN subscriptions ON subscriptions.subscription = :USERNAME WHERE subscriptions.subscriber = users.username AND users.i_gender != 0 AND subscriptions.submit_date > :DATE GROUP BY users.i_gender ORDER BY amount DESC",false,[":USERNAME" => $_USER->Username, ":DATE" => $DBDate]);

$Gender_Total = $DB->execute("SELECT count(users.i_gender) as amount FROM users INNER JOIN subscriptions ON subscriptions.subscription = :USERNAME WHERE subscriptions.subscriber = users.username AND users.i_gender != 0 AND subscriptions.submit_date > :DATE",true,[":USERNAME" => $_USER->Username, ":DATE" => $DBDate])['amount'];

if ($Gender_Total > 0) {
foreach ($Gender as $Gender_Num) {
  if ($Gender_Num['gender'] == 1) {
    $Gender_1 = ($Gender_Num['amount'] / $Gender_Total) * 100;
  }
  else if ($Gender_Num['gender'] == 2) {
    $Gender_2 = ($Gender_Num['amount'] / $Gender_Total) * 100;
  }
}
}
else {
  $Gender_1 = 0;
  $Gender_2 = 0;
}
}
if (isset($_GET['page']) && $_GET['page'] == "community") { 
$Daily_Comments = $DB->execute("SELECT IFNULL(B.Total,0) AS Total, A.dates AS Date FROM
(SELECT ADDDATE('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) as dates FROM
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4) A 
LEFT JOIN
(SELECT
  count(videos_comments.id) as total,
  DATE(videos_comments.submit_on) as date
FROM videos_comments INNER JOIN videos ON videos.url = videos_comments.url
WHERE videos.uploaded_by = '$_USER->Username' AND DATE(videos_comments.submit_on) between date('$StartDate') and date(curdate())
GROUP BY CAST(videos_comments.submit_on AS date)) B 
ON A.dates=B.date  
WHERE A.dates BETWEEN '$StartDate' and curdate()
ORDER BY `Date` ASC");

$Daily_Ratings = $DB->execute("SELECT IFNULL(B.Total,0) AS Total, A.dates AS Date FROM
(SELECT ADDDATE('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) as dates FROM
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4) A 
LEFT JOIN
(SELECT
  count(videos_ratings.url) as total,
  DATE(videos_ratings.submit_date) as date
FROM videos_ratings INNER JOIN videos ON videos.url = videos_ratings.url
WHERE videos.uploaded_by = '$_USER->Username' AND DATE(videos_ratings.submit_date) between date('$StartDate') and date(curdate())
GROUP BY CAST(videos_ratings.submit_date AS date)) B 
ON A.dates=B.date  
WHERE A.dates BETWEEN '$StartDate' and curdate()
ORDER BY `Date` ASC");

$Daily_Favorites = $DB->execute("SELECT IFNULL(B.Total,0) AS Total, A.dates AS Date FROM
(SELECT ADDDATE('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) as dates FROM
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4) A 
LEFT JOIN
(SELECT
  count(videos_favorites.url) as total,
  DATE(videos_favorites.submit_on) as date
FROM videos_favorites INNER JOIN videos ON videos.url = videos_favorites.url
WHERE videos.uploaded_by = '$_USER->Username' AND DATE(videos_favorites.submit_on) between date('$StartDate') and date(curdate())
GROUP BY CAST(videos_favorites.submit_on AS date)) B 
ON A.dates=B.date  
WHERE A.dates BETWEEN '$StartDate' and curdate()
ORDER BY `Date` ASC");

$Daily_Interactions = [];

if (!isset($_GET['i']) || isset($_GET['i']) && $_GET['i'] == "a") {
foreach($Daily_Comments as $key => $value){
  $Daily_Interactions[$key]['Total'] = $value['Total'] + ($Daily_Interactions[$key] ?? 0.0);
  $Daily_Interactions[$key]['Date'] = $value['Date'];
}

foreach($Daily_Ratings as $key => $value){
  $Daily_Interactions[$key]['Total'] += $value['Total'];
}

foreach($Daily_Favorites as $key => $value){
  $Daily_Interactions[$key]['Total'] += $value['Total'];
}
}
if (isset($_GET['i']) && $_GET['i'] == "c") {
  $Daily_Interactions = $Daily_Comments;
}
if (isset($_GET['i']) && $_GET['i'] == "f") {
  $Daily_Interactions = $Daily_Favorites;
}
if (isset($_GET['i']) && $_GET['i'] == "r") {
  $Daily_Interactions = $Daily_Ratings;
}

$Countries = $DB->execute("SELECT users.i_country as country, count(users.i_country) as amount FROM users INNER JOIN subscriptions ON subscriptions.subscription = :USERNAME WHERE subscriptions.subscriber = users.username AND users.i_country != '' AND subscriptions.submit_date > :DATE GROUP BY users.i_country ORDER BY amount DESC", false, [":USERNAME" => $_USER->Username, ":DATE" => $DBDate]);
}

if (isset($_GET['t']) && $_GET['t'] == "t") {
$StartDate = date("Y-m-d",strtotime((string) $_USER->Info['registration_date']));
$DBDate = "DATE_SUB(NOW(), INTERVAL 100 YEAR)";
}

$Daily_Subs = $DB->execute("SELECT IFNULL(B.Total,0) AS Total, A.dates AS Date FROM
(SELECT ADDDATE('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) as dates FROM
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4) A 
LEFT JOIN
(SELECT
  COUNT(*) as total,
  DATE(subscriptions.submit_date) as date
FROM subscriptions INNER JOIN users ON subscriptions.subscription = users.username
where 
  subscriptions.subscription = :USERNAME AND is_banned = 0 AND DATE(subscriptions.submit_date) between date('$StartDate') and date(curdate())
GROUP BY CAST(submit_date AS date)) B 
ON A.dates=B.date  
WHERE A.dates BETWEEN '$StartDate' and curdate()
ORDER BY `Date` ASC",false,[":USERNAME" => $_USER->Username]);

if (isset($_GET['t']) && $_GET['t'] == "t") {

for ($i = 1; $i <= $DB->Row_Num - 1; $i++) {
    $n = $i - 1;
    $Daily_Subs[$i]['Total'] += $Daily_Subs[$n]['Total'];
}

}

}

else {
  $_VIDEO = new Video($_GET["v"],$DB);
  if (!$_VIDEO->exists()) { header("location: /"); exit(); }
  $_VIDEO->get_info();
  $_VIDEO->check_info();

  if ($_VIDEO->Info['uploaded_by'] != $_USER->Username) { header("location: /"); exit(); }

  $UplDt = date("Y-m-d",strtotime((string) $_VIDEO->Info['uploaded_on']));

  if (isset($_GET['i']) && $_GET['i'] == "d" || isset($_GET['i']) && $_GET['i'] == "t" || !isset($_GET['i'])) {
  $Daily_Views = $DB->execute("SELECT IFNULL(B.Total,0) AS Total, A.dates AS Date FROM
(SELECT ADDDATE('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) as dates FROM
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4) A 
LEFT JOIN
(SELECT
  sum(views_day.views) as total,
  DATE(views_day.submit_date) as date
FROM views_day INNER JOIN videos ON videos.url = views_day.url
WHERE views_day.url = :URL AND DATE(views_day.submit_date) between date('$UplDt') and date(curdate())
GROUP BY CAST(views_day.submit_date AS date)) B 
ON A.dates=B.date  
WHERE A.dates BETWEEN '$UplDt' and curdate()
ORDER BY `Date` ASC",false,[":URL" => $_VIDEO->URL]);

if (isset($_GET['i']) && $_GET['i'] == "t") {
  for ($i = 1; $i <= $DB->Row_Num - 1; $i++) {
      $n = $i - 1;
      $Daily_Views[$i]['Total'] += $Daily_Views[$n]['Total'];
  }
}
}

if (isset($_GET['i']) && $_GET['i'] == "r") {
  $Daily_Views = $DB->execute("SELECT IFNULL(B.Total,0) AS Total, A.dates AS Date FROM
(SELECT ADDDATE('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) as dates FROM
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4) A 
LEFT JOIN
(SELECT
  count(videos_ratings.url) as total,
  DATE(videos_ratings.submit_date) as date
FROM videos_ratings INNER JOIN videos ON videos.url = videos_ratings.url
WHERE videos_ratings.url = :URL AND DATE(videos_ratings.submit_date) between date('$UplDt') and date(curdate())
GROUP BY CAST(videos_ratings.submit_date AS date)) B 
ON A.dates=B.date  
WHERE A.dates BETWEEN '$UplDt' and curdate()
ORDER BY `Date` ASC",false,[":URL" => $_VIDEO->URL]);
}

if (isset($_GET['i']) && $_GET['i'] == "c") {
  $Daily_Views = $DB->execute("SELECT IFNULL(B.Total,0) AS Total, A.dates AS Date FROM
(SELECT ADDDATE('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) as dates FROM
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4) A 
LEFT JOIN
(SELECT
  count(videos_comments.url) as total,
  DATE(videos_comments.submit_on) as date
FROM videos_comments INNER JOIN videos ON videos.url = videos_comments.url
WHERE videos_comments.url = :URL AND DATE(videos_comments.submit_on) between date('$UplDt') and date(curdate())
GROUP BY CAST(videos_comments.submit_on AS date)) B 
ON A.dates=B.date  
WHERE A.dates BETWEEN '$UplDt' and curdate()
ORDER BY `Date` ASC",false,[":URL" => $_VIDEO->URL]);
}

if (isset($_GET['i']) && $_GET['i'] == "f") {
  $Daily_Views = $DB->execute("SELECT IFNULL(B.Total,0) AS Total, A.dates AS Date FROM
(SELECT ADDDATE('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) as dates FROM
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
(SELECT 0 i UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4) A 
LEFT JOIN
(SELECT
  count(videos_favorites.url) as total,
  DATE(videos_favorites.submit_on) as date
FROM videos_favorites INNER JOIN videos ON videos.url = videos_favorites.url
WHERE videos_favorites.url = :URL AND DATE(videos_favorites.submit_on) between date('$UplDt') and date(curdate())
GROUP BY CAST(videos_favorites.submit_on AS date)) B 
ON A.dates=B.date  
WHERE A.dates BETWEEN '$UplDt' and curdate()
ORDER BY `Date` ASC",false,[":URL" => $_VIDEO->URL]);
}

}

$_PAGE = [
    "Page"          => "insight",
    "Page_Type"     => "my_videos",
];
require "_templates/_structures/main.php";