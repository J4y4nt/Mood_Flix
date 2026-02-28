<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MoodFlix</title>

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
    --text:#111111;
    --glass: rgba(0,0,0,0.05);
    --border: rgba(0,0,0,0.1);
    --accent1:#ff4ecd;
    --accent2:#7c4dff;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    min-height:100vh;
    background:var(--bg);
    color:var(--text);
    display:flex;
    flex-direction:column;
    transition:0.4s ease;
}

header{
    position:fixed;
    width:100%;
    padding:20px 50px;
    font-size:24px;
    font-weight:600;
    background:var(--glass);
    backdrop-filter:blur(15px);
    border-bottom:1px solid var(--border);
    display:flex;
    justify-content:space-between;
    align-items:center;
    z-index:100;
}

.theme-toggle{
    cursor:pointer;
    padding:8px 15px;
    border-radius:20px;
    border:1px solid var(--border);
    background:var(--glass);
    transition:0.3s;
}

.theme-toggle:hover{
    background:linear-gradient(90deg,var(--accent1),var(--accent2));
    color:#fff;
}

.container{
    flex:1;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    text-align:center;
    padding:140px 20px 40px;
}

h1{
    font-size:48px;
    max-width:850px;
    margin-bottom:60px;
    background:linear-gradient(90deg,var(--accent1),var(--accent2));
    -webkit-background-clip:text;
    background-clip:text;
    -webkit-text-fill-color:transparent;
    color:transparent;
}

.mood-buttons{
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:18px;
    max-width:900px;
}

.mood-buttons button{
    padding:14px 28px;
    border-radius:40px;
    border:1px solid var(--border);
    background:var(--glass);
    color:var(--text);
    cursor:pointer;
    transition:0.3s ease;
}

.mood-buttons button:hover{
    background:linear-gradient(90deg,var(--accent1),var(--accent2));
    color:#fff;
    transform:translateY(-5px);
    box-shadow:0 0 20px rgba(124,77,255,0.5);
}

@media(max-width:768px){
    h1{font-size:30px;}
}
</style>
</head>

<body>

<header>
    <div>🎬 MoodFlix</div>
    <div class="theme-toggle" onclick="toggleTheme()">🌙 / ☀</div>
</header>

<div class="container">
<h1>Find the Perfect Anime Based on Your Mood</h1>

<form action="result.php" method="GET" class="mood-buttons">
<button type="submit" name="mood" value="action">⚔ Action</button>
<button type="submit" name="mood" value="romance">💖 Romance</button>
<button type="submit" name="mood" value="psychological">🧠 Psychological</button>
<button type="submit" name="mood" value="comedy">😂 Comedy</button>
<button type="submit" name="mood" value="fantasy">🪄 Fantasy</button>
<button type="submit" name="mood" value="horror">👻 Horror</button>
<button type="submit" name="mood" value="mystery">🕵 Mystery</button>
<button type="submit" name="mood" value="sci-fi">🚀 Sci-Fi</button>
<button type="submit" name="mood" value="slice-of-life">🌸 Slice of Life</button>
<button type="submit" name="mood" value="sports">🏀 Sports</button>
<button type="submit" name="mood" value="surprise">🎲 Surprise Me</button>
</form>
</div>

<script>
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
</script>

</body>
</html>