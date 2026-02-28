<?php
$genreMap = [
    'action' => [1], 'romance' => [22], 'psychological' => [40],
    'comedy' => [4], 'fantasy' => [10], 'horror' => [14],
    'mystery' => [7], 'sci-fi' => [24], 'slice-of-life' => [36],
    'sports' => [30], 'surprise' => [1,4,7,10,14,22,24,30,36,40]
];

if(!isset($_GET['mood']) || !array_key_exists($_GET['mood'], $genreMap)){
    header('Location: index.php'); exit();
}

$mood = $_GET['mood'];

if($mood === 'surprise'){
    shuffle($genreMap['surprise']);
    $selectedGenres = array_slice($genreMap['surprise'],0,3);
} else {
    $selectedGenres = $genreMap[$mood];
}

$genreNames = [1=>'Action',4=>'Comedy',7=>'Mystery',10=>'Fantasy',14=>'Horror',22=>'Romance',24=>'Sci-Fi',30=>'Sports',36=>'Slice of Life',40=>'Psychological'];

$displayGenres=[];
foreach($selectedGenres as $g){
    $displayGenres[]=$genreNames[$g];
}

$genreQuery = implode(',', $selectedGenres);
$apiUrl = "https://api.jikan.moe/v4/anime?genres={$genreQuery}&order_by=score&sort=desc&limit=20";

$animeList=[];
$apiResponse=@file_get_contents($apiUrl);
if($apiResponse!==false){
    $data=json_decode($apiResponse,true);
    if(isset($data['data'])) $animeList=$data['data'];
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>MoodFlix - <?= htmlspecialchars(ucfirst($mood)) ?></title>

<style>
:root{
    --bg: linear-gradient(135deg,#0f0f1a,#1a1a2e,#16213e);
    --text:#ffffff;
    --glass: rgba(255,255,255,0.05);
    --border: rgba(255,255,255,0.1);
    --accent1:#ff4ecd;
    --accent2:#7c4dff;
}

body.light{
    --bg: linear-gradient(135deg,#f5f7fa,#e4ecf7,#ffffff);
    --text:#111;
    --glass: rgba(0,0,0,0.05);
    --border: rgba(0,0,0,0.1);
}

body{
    margin:0;
    font-family:'Poppins',sans-serif;
    background:var(--bg);
    color:var(--text);
    transition:0.4s ease;
}

header{
    position:fixed;
    width:100%;
    padding:20px 50px;
    background:var(--glass);
    backdrop-filter:blur(15px);
    border-bottom:1px solid var(--border);
    display:flex;
    justify-content:space-between;
    align-items:center;
    z-index:100;
}

.container{
    padding:140px 40px 40px;
    text-align:center;
}

h1{
    font-size:38px;
    background:linear-gradient(90deg,var(--accent1),var(--accent2));
    -webkit-background-clip:text;
    background-clip:text;
    -webkit-text-fill-color:transparent;
    color:transparent;
}

.anime-list{
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:25px;
    margin-top:30px;
}

.anime-card{
    width:220px;
    position:relative;
    border-radius:20px;
    overflow:hidden;
    background:var(--glass);
    border:1px solid var(--border);
    transition:0.3s ease;
    cursor:pointer;
}

.anime-card img{
    width:100%;
    display:block;
}

.anime-info{
    padding:10px;
}

.overlay{
    position:absolute;
    inset:0;
    background:rgba(0,0,0,0.92);
    color:#fff;
    padding:15px;
    opacity:0;
    visibility:hidden;
    transition:opacity 0.4s ease;
    overflow-y:auto;
    font-size:13px;
}

.overlay.show{
    opacity:1;
    visibility:visible;
}

a.button{
    display:inline-block;
    margin-top:40px;
    padding:12px 30px;
    border-radius:40px;
    background:linear-gradient(90deg,var(--accent1),var(--accent2));
    text-decoration:none;
    color:#fff;
}
</style>
</head>

<body>

<header>
<div>🎬 MoodFlix</div>
<div onclick="toggleTheme()" style="cursor:pointer;">🌙 / ☀</div>
</header>

<div class="container">
<h1><?= ucfirst($mood) ?> Anime Recommendations</h1>

<div class="anime-list">
<?php foreach($animeList as $anime): ?>
<div class="anime-card">
    <img src="<?= htmlspecialchars($anime['images']['jpg']['image_url']??'') ?>">
    <div class="anime-info">
        <strong><?= htmlspecialchars($anime['title']) ?></strong><br>
        ⭐ <?= htmlspecialchars($anime['score']??'N/A') ?>
    </div>
    <div class="overlay">
        <?= htmlspecialchars(substr($anime['synopsis']??'No description available.',0,500)) ?>...
    </div>
</div>
<?php endforeach; ?>
</div>

<a href="index.php" class="button">Choose Another Mood</a>
</div>

<script>
// THEME
function toggleTheme(){
    document.body.classList.toggle("light");
    localStorage.setItem("theme",
        document.body.classList.contains("light") ? "light" : "dark"
    );
}

window.onload = function(){
    if(localStorage.getItem("theme") === "light"){
        document.body.classList.add("light");
    }
}

// ✅ 1.5 SECOND HOVER DELAY
document.querySelectorAll('.anime-card').forEach(card=>{
    let timer;
    const overlay = card.querySelector('.overlay');

    card.addEventListener('mouseenter', ()=>{
        timer = setTimeout(()=>{
            overlay.classList.add('show');
        }, 1500); // 1.5 seconds
    });

    card.addEventListener('mouseleave', ()=>{
        clearTimeout(timer);
        overlay.classList.remove('show');
    });
});
</script>

</body>
</html>